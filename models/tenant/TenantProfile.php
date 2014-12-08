<?php

namespace gxc\yii2base\models\tenant;

use gxc\yii2base\classes\TbActiveRecord;
use Yii;

/**
 * This is the model class for table "base_tenant_profile".
 *
 * @property string $id
 * @property string $store
 * @property string $user_registered_id
 * @property string $address_registered_id
 * @property string $registered_at
 */
class TenantProfile extends TbActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_tenant_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_registered_id', 'registered_at'], 'required'],
            [['user_registered_id', 'address_registered_id'], 'integer'],
            [['registered_at'], 'safe'],
            [['store'], 'string', 'max' => 64]
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
            'user_registered_id' => Yii::t('base', 'User Registered ID'),
            'address_registered_id' => Yii::t('base', 'Address Registered ID'),
            'registered_at' => Yii::t('base', 'Registered At'),
        ];
    }
}
