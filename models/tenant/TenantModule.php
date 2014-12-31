<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\tenant;

use Yii;

use gxc\yii2base\classes\TbActiveRecord;

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
            [['permissions'], 'string'],
            [['expiry_mode', 'status'], 'integer'],
            [['expired_at'], 'safe'],
            [['store', 'module', 'plan'], 'string', 'max' => 64],
            [['store', 'module'], 'unique', 'targetAttribute' => ['store', 'module'], 'message' => 'The combination of Store and Module has already been taken.']
        ];
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
}
