<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\tenant;

use gxc\yii2base\models\user\UserDisplay;
use gxc\yii2base\widgets\TimeFromX;
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
    const EXPIRED_MODE_NONE = 1;
    const EXPIRED_MODE_TIME = 2;

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
            [['module', 'plan', 'expiry_mode'], 'required'],
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
        if (empty($this->expired_at) && $this->expiry_mode != self::EXPIRED_MODE_NONE)
            $this->expired_at = Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');

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
            self::EXPIRED_MODE_NONE => Yii::t('base', 'Never expire'),
            self::EXPIRED_MODE_TIME => Yii::t('base', 'Expired at a Specific time')
        ];
    }

    public function getUpdatedUser()
    {
        $userDisplay = \Yii::$app->tenant->getModel('UserDisplay', 'class');
        return $this->hasOne($userDisplay::classname(), ['user_id' => 'updated_by']);
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

    public static function getModuleInfo($tid, $module)
    {
        $html = '';
        $moduleInfo = ModuleHelper::getModule($module->module);
        if(!empty($moduleInfo)) {
            $html .= Html::a(Html::tag('strong', $moduleInfo['name']),
                ['module-form', 'mid' => $module->id, 'tid' => $tid],
                [
                    'data-toggle' => 'modal',
                    'data-target' => '#module-form',
                ]);
            $html .= Html::tag('br');
            $html .= Html::tag('span', Yii::t('base', 'Plan') . ': '. $moduleInfo['plans'][$module->plan]['name'], ['class' => 'info-desc']);
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

    /**
     * render expired at information
     *
     * @param $model
     * @return string
     */
    public static function renderExpiredAt($model)
    {
        $html = '';

        $expired_at = Yii::$app->locale->toLocalTime($model->expired_at, null)->getTimestamp();

        // set status html
        switch ($model->status) {
            case self::STATUS_ACTIVE:
            case self::STATUS_NEAR_EXPIRE_WEEK:
                $status = Html::tag('span', '', ['class' => 'statusDot statusDot-success']);
                break;

            case self::STATUS_PENDING:
                $status = Html::tag('span', '', ['class' => 'statusDot statusDot-warning']);
                break;

            case self::STATUS_INACTIVE:
            case self::STATUS_NEAR_EXPIRE_DAY:
                $status = Html::tag('span', '', ['class' => 'statusDot statusDot-danger']);
                break;

            default:
                $status = '';
        }

        // check mode
        if ($model->expiry_mode == self::EXPIRED_MODE_NONE) {
            $html .= Html::tag('p', Html::tag('b', Yii::t('base', 'Never expires')) . str_replace('"', '\'', $status), ['style' => 'margin:0;']);

        } elseif ($model->expiry_mode == self::EXPIRED_MODE_TIME) {
            $html .= TimeFromX::widget([
                'name' => 'tenant_module_expire',
                'value' => $expired_at,
                'template' => Yii::t('base', 'Expires in ') . ' <b>{time}</b>' . str_replace('"', '\'', $status),
                'options' => ['style' => 'margin:0;']
            ]);
            $html .= Html::tag('span', date('d/M/Y', $expired_at), ['info-desc']);
        }

        // return html
        return $html;
    }

    public static function renderUpdatedBy($model)
    {
        $html = '';

        $html .= Html::tag('p', Yii::t('base', 'Updated') . ': ' . Yii::t('base', "Manual"), ['style' => 'margin: 0;']);
        $html .= Html::tag('p', Yii::t('base', 'by') . ' ' . $model->updatedUser->display_name, ['style' => 'margin: 0;']);

        return $html;
    }
}
