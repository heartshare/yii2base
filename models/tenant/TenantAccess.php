<?php

namespace gxc\yii2base\models\tenant;

use Yii;

/**
 * This is the model class for table "base_tenant_access".
 *
 * @property string $id
 * @property string $store
 * @property string $user_id
 * @property integer $level
 * @property integer $status
 */
class TenantAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_tenant_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'level', 'status'], 'integer'],
            [['store'], 'string', 'max' => 64],
            [['user_id', 'level', 'store'], 'unique', 'targetAttribute' => ['user_id', 'level', 'store'], 'message' => 'The combination of Store, User ID and Level has already been taken.']
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
            'user_id' => Yii::t('base', 'User ID'),
            'level' => Yii::t('base', 'Level'),
            'status' => Yii::t('base', 'Status'),
        ];
    }
}
