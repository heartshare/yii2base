<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;
use gxc\yii2base\classes\TbActiveRecord;

/**
 * This is the model class for table "base_user".
 *
 * @property string $id
 * @property string $store
 * @property string $email
 * 
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class User extends TbActiveRecord
{
    // Define user gender constant
    const USER_GENDER_MALE = 1;
    const USER_GENDER_FEMALE = 2;

    // Define user zone constant
    const USER_ZONE_STAFF = 'staff';
    const USER_ZONE_GUEST = 'guest';
    const USER_ZONE_ALL = 'staff_guest';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['store'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 128],
            [['store', 'email'], 'unique', 'targetAttribute' => ['store', 'email'], 'message' => \Yii::t('base','Email has already been taken.')],
            [['store'], 'safe']
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
            'email' => Yii::t('base', 'Email'),
        ];
    }

    public function getIdentityInfo()
    {
        // User has_one UserIdentity via UserIdentity.user_id -> id
        return $this->hasOne(UserIdentity::className(), ['user_id' => 'id']);
    }

    public function getDisplayInfo()
    {
        // User has_one UserDisplay via UserDisplay.user_id -> id
        return $this->hasOne(UserDisplay::className(), ['user_id' => 'id']);
    }

    public function getProfileInfo()
    {
        // User has_one UserProfile via UserProfile.user_id -> id
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

     public function getPermissionInfo()
    {
        // User has_one UserPermission via UserPermission.user_id -> id
        return $this->hasOne(UserPermission::className(), ['user_id' => 'id']);
    }

    /**
     * Finds user by email
     *
     * @param string Email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

     /**
     * Get User Zones
     *
     * @return array
     */
    public static function getUserZones()
    {
        return [
            self::USER_ZONE_STAFF => Yii::t('base', 'Staff Zone'),
            self::USER_ZONE_GUEST => Yii::t('base', 'Guest Zone'),
            self::USER_ZONE_ALL => Yii::t('base', 'Both Staff and Guest'),
        ];
    }

    /**
     * Get User Genders
     *
     * @return array
     */
    public static function getUserGenders()
    {
        return [
            self::USER_GENDER_MALE => Yii::t('base', 'Male'),
            self::USER_GENDER_FEMALE => Yii::t('base', 'Female'),
        ];
    }
}
