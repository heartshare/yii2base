<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */
namespace gxc\yii2base\models\tenant;

use gxc\yii2base\classes\TbActiveRecord;
use Yii;

/**
 * Tenant Profile
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
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
