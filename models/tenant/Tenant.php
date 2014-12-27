<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\tenant;

use gxc\yii2base\helpers\UtilHelper;
use gxc\yii2base\models\user\User;
use Yii;
use yii\helpers\BaseFormatConverter;
use yii\helpers\Html;

use gxc\yii2base\classes\TbActiveRecord;
use gxc\yii2base\helpers\BaseHelper;
use yii\i18n\I18N;
use yii\web\View;
use gxc\yii2base\models\user\UserDisplay;

/**
 * This is the model class for table "base_tenant".
 *
 * @author  Tung Mang Vien<tungmv7@gmail.com>
 * @since  2.0
 */
class Tenant extends TbActiveRecord
{
    // Define tenant status constant
    const TENANT_STATUS_INACTIVE = 0;
    const TENANT_STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_tenant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['app_store', 'content_store', 'resource_store'], 'string', 'max' => 64],
            [['name', 'domain', 'system_domain', 'logo'], 'string', 'max' => 128],
            [['app_store', 'domain', 'system_domain'], 'unique'],
            [['domain', 'system_domain'], 'url'],
            [['name', 'domain', 'system_domain', 'status'], 'required'],
            [['app_store', 'content_store', 'resource_store'], 'required', 'on' => 'update']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base', 'ID'),
            'app_store' => Yii::t('base', 'App Store'),
            'content_store' => Yii::t('base', 'Content Store'),
            'resource_store' => Yii::t('base', 'Resource Store'),
            'name' => Yii::t('base', 'Name'),
            'domain' => Yii::t('base', 'Domain'),
            'system_domain' => Yii::t('base', 'System Domain'),
            'logo' => Yii::t('base', 'Logo'),
            'status' => Yii::t('base', 'Status'),
        ];
    }

    public function afterSave()
    {
        parent::afterSave($this->isNewRecord, $this);
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {

            // Auto Generate Store if not having
            if (empty($this->app_store))
                $this->app_store = BaseHelper::generateTenantStoreId('a');;
            // init content store code
            if (empty($this->content_store))
                $this->content_store = BaseHelper::generateTenantStoreId('c');;
            // init resource store code
            if (empty($this->resource_store))
                $this->resource_store = BaseHelper::generateTenantStoreId('r');
            return true; 
        }
    }

    public function getProfile()
    {
        return $this->hasOne(TenantProfile::classname(), ['store' => 'app_store']);
    }

    public function getOwner()
    {
        return $this->hasOne(UserDisplay::classname(), ['user_id' => 'user_registered_id'])->via('profile');
    }

    public function getAccount()
    {
        return $this->hasOne(User::className(), ['id' => 'user_registered_id'])->via('profile');
    }

    /**
     * get all tenant store information by app | content | resource
     *
     * @param $which
     * @return array
     */
    public static function getTenantStores($which, $model = false)
    {
        $appStores = [];

        switch ($which) {
            case 'app':
                if ($model != false) {
                    $ternant = TenantSearch::findOne(['id' => $model->id]);
                    if (!empty($ternant))
                        $appStores[$ternant->app_store] = $ternant->name . ' - ' . $ternant->app_store;
                }
                break;

            case 'content':
                $tenantSearch = TenantSearch::findAll(['status' => self::TENANT_STATUS_ACTIVE]);
                foreach ($tenantSearch as $ternant) {
                    $appStores[$ternant->content_store] = $ternant->name . ' - ' . $ternant->content_store;
                }
                break;

            case 'resource':
                $tenantSearch = TenantSearch::findAll(['status' => self::TENANT_STATUS_ACTIVE]);
                foreach ($tenantSearch as $ternant) {
                    $appStores[$ternant->resource_store] = $ternant->name . ' - ' . $ternant->resource_store;
                }
                break;
        }

        return $appStores;

    }

    /**
     * Render Tenant Status Label
     *
     * @return string
     */
    public static function renderTenantStatus($state)
    {
        switch ($state) {
            case self::TENANT_STATUS_ACTIVE:
                return Html::tag('span', Yii::t('base', 'Active'), ['class' => 'label label-success']);
            case self::TENANT_STATUS_INACTIVE:
                return Html::tag('span', Yii::t('base', 'Inactive'), ['class' => 'label label-danger']);
            default:
                return '';
        }
    }

    /**
     * Get Tenant Statuses
     *
     * @return array
     */
    public static function getTenantStatuses()
    {
        return [
            self::TENANT_STATUS_ACTIVE => Yii::t('base', 'Active'),
            self::TENANT_STATUS_INACTIVE => Yii::t('base', 'Inactive'),
        ];
    }

    /**
     * render base Tenant information in gridview
     *
     * @param $tenant
     * @param bool $view
     * @return string
     */
    public static function renderBasicInfo($tenant, $view = false)
    {
        $html = '';

        // get tenant name
        // format: <strong><a href="#" class="name-info">Phuong Sex Store</a></strong>
        $html .= Html::a(Html::tag('strong', $tenant->name), ['view', 'id' => $tenant->id], ['class' => 'name-info', 'style' => 'vertical-align: middle; line-height: 18px;']);
        // get tenant status
        // format: <span class="label label-success">Active</span>
        $html .= "\n" . self::renderTenantStatus($tenant->status);

        // get tenant domain
        // format: <p><a href="http://tungmv.com" target="_blank">http://psestoreofphuong.com</a></p>
        $html .= "\n" . Html::tag('p', Html::a($tenant->domain, $tenant->domain, ['target' => '_blank']));

        // get registered time
        // format: <p class="join-des"><span>Registered 20 days ago.</span></p>
        // we use moment.js fromNow from unix timestamp to optimize
        // http://momentjs.com/docs/#/displaying/fromnow/
        if($view !== false) {
            $duration = Yii::$app->locale->toLocalTime($tenant->profile->registered_at, null)->getTimestamp();
            $html .= "\n" . Html::tag('p', Html::hiddenInput('registered_time_ago', $duration, ['id' => 'duration_' . $tenant->id]), ['class' => 'join-des']);
            $durationJs = '$("#duration_'.$tenant->id.'").parent().html("<span>'.Yii::t('base', 'Registered ').'"+moment.unix($("#duration_'.$tenant->id.'").val()).fromNow()+"</span>");';
            $view->registerJs($durationJs, View::POS_READY);
        }

        return $html;
    }

    /**
     * render tenant logo base logoPath and resource path
     *
     * @param $logoPath
     * @return string
     */
    public static function renderLogo($logoPath)
    {
        if(!empty($logoPath)){
            return '';
        }else{
            return Html::tag('span', Html::tag('span','', ['class'=>'fa fa-user fa-4x text-primary']), ['class' => 'thumb-wrapper-circle']);
        }
    }


    public static function renderContactInfo($model)
    {

        if(!empty($model->owner)) {
            $html = '';
            // get user display name
            // format: <strong class="name-info">Phuong Nguyen</strong>
            $html .= Html::tag('strong', $model->owner->display_name, ['class' => 'name-info']);
            $html .= "\n" . Html::tag('br');

            // get address info
            // email: <i class="fa fa-envelope"></i> <span><a href="#">phuongxa@gmail.com</a></span>
            $html .= Html::tag('i', '', ['class' => 'fa fa-envelope']);
            $html .= "\n" . Html::tag('span', Html::a($model->account->email, ['mailto:'.$model->account->email]));
            $html .= "\n" . Html::tag('br');

            // phone:  <i class="fa fa-phone"></i> <span>+84230292311</span>
            $html .= "\n" . Html::tag('i', '', ['class' => 'fa fa-phone']);
            $html .= "\n" . Html::tag('span', '+84230292311');
            return $html;
        }else
            return '';

    }
}
