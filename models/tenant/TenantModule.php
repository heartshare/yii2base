<?php

namespace gxc\yii2base\models\tenant;

use Yii;

/**
 * This is the model class for table "base_tenant_module".
 *
 * @property string $id
 * @property string $store
 * @property string $module
 * @property string $plan
 * @property string $permissions
 * @property integer $expired_mode
 * @property string $expired_at
 * @property integer $status
 */
class TenantModule extends \yii\db\ActiveRecord
{
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
            [['expired_mode', 'status'], 'integer'],
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
            'expired_mode' => Yii::t('base', 'Expired Mode'),
            'expired_at' => Yii::t('base', 'Expired At'),
            'status' => Yii::t('base', 'Status'),
        ];
    }
}
