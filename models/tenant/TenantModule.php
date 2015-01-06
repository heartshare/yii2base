<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\tenant;

use Yii;

use gxc\yii2base\classes\TbActiveRecord;

use gxc\yii2base\helpers\ModuleHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "base_tenant_module".
 *
 * @author  Tung Mang Vien <tungmv7@gmail.com>
 * @since  2.0
 */
class TenantModule extends TbActiveRecord
{
    const EXPIRED_MODE_TIME = 1;
    const EXPIRED_MODE_SUBSCRIPTION = 2;
    const EXPIRED_MODE_PARTNER = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_PENDING = 3;
    const STATUS_NEAR_EXPIRE_WEEK = 4;
    const STATUS_NEAR_EXPIRE_DAY = 5;

    const UPDATE_MODE_AUTO = 1;
    const UPDATE_MODE_MANUAL = 2;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_tenant_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'store', 'plan', 'expiry_mode'], 'required'],
            [['permissions'], 'string'],
            [['expiry_mode', 'status'], 'integer'],
            [['expired_at'], 'safe'],
            [['store', 'module', 'plan'], 'string', 'max' => 64],
            [['store', 'module'], 'unique', 'targetAttribute' => ['store', 'module'], 'message' => 'The combination of Store and Module has already been taken.']
        ];
    }

    public function beforeSave()
    {
        parent::beforeSave($this->isNewRecord);

        $this->updated_at = Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
        if ($this->isNewRecord) {

        } else {

        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base', 'ID'),
            'store' => Yii::t('base', 'Store'),
            'module' => Yii::t('base', 'Module'),
            'plan' => Yii::t('base', 'Plan'),
            'permissions' => Yii::t('base', 'Permissions'),
            'expiry_mode' => Yii::t('base', 'Expired Mode'),
            'expired_at' => Yii::t('base', 'Expired At'),
            'status' => Yii::t('base', 'Status'),
        ];
    }

    public function getExpiredModes()
    {
        return [
            self::EXPIRED_MODE_TIME => Yii::t('base', 'Expired at a Specific time'),
            self::EXPIRED_MODE_SUBSCRIPTION => Yii::t('base', 'Expired by Subscription Plan'),
            self::EXPIRED_MODE_PARTNER => Yii::t('base', 'Expired by Partner Contraction')
        ];
    }

    public static function calculateExpireTimeByManual()
    {

    }

    public static function calculateExpireTimeBySubscription($type)
    {

    }

    public static function getModuleLogo($id)
    {
        return ModuleHelper::getModule($id)['icon'];
    }

    public function getModuleInfo()
    {
        $html = '';
        $moduleInfo = ModuleHelper::getModule($this->module);
        if(!empty($moduleInfo)) {
            $html .= Html::a(Html::tag('strong', $moduleInfo['name']),
                ['module-form', 'mid' => $this->id, 'tid' => 1],
                [
                    'data-toggle' => 'modal',
                    'data-target' => '#module-form',
                ]);
            $html .= Html::tag('br');
            $html .= Html::tag('span', Yii::t('base', 'Plan') . ': '. $moduleInfo['plans'][$this->plan]['name'], ['class' => 'info-desc']);
        }
        return $html;

    }

    /**
     * get module and plan info
     *
     * @param $id
     * @return array
     */
    public static function getModuleExtraInfo($id)
    {
        $moduleInfo = ModuleHelper::getModule($id);

        $module = '';
        if(!empty($moduleInfo['icon']))
            $module .= Html::img($moduleInfo['icon']);
        if(isset($moduleInfo['name']))
            $module .= Html::tag('h4', $moduleInfo['name']);
        if(isset($moduleInfo['description'])) {
            $module .= Html::tag('p', $moduleInfo['description']);
            $module .= Html::a(Yii::t('base', 'View plan pricing'), '#');
        }

        $plans = '';
        if(!empty($moduleInfo['plans'])){
            foreach($moduleInfo['plans'] as $k => $plan) {
                $plans .= Html::tag('option', $plan['name'], ['value' => $k]);
            }
        } else {
            $plans .= Html::tag('option', Yii::t('base', '-- Select -- '));
        }

        return [$module, $plans];
    }

    public static function renderUpdateTime($model)
    {

    }
}
