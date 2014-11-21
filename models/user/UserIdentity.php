<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;

/**
 * This is the model class for table "base_user_identity".
 *
 * @property string $id
 * @property string $store
 * @property string $user_id
 * @property string $zone
 * @property string $auth_provider
 * @property string $auth_provider_uid
 * @property string $auth_params
 * @property string $auth_key
 * @property string $password_hash
 * @property integer $login_attempts
 * @property string $recent_login
 * @property string $recent_password_change
 * @property integer $status
 * 
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserIdentity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_identity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'auth_key', 'password_hash', 'recent_login', 'recent_password_change'], 'required'],
            [['user_id', 'login_attempts', 'status'], 'integer'],
            [['auth_params'], 'string'],
            [['recent_login', 'recent_password_change'], 'safe'],
            [['store', 'zone'], 'string', 'max' => 64],
            [['auth_provider', 'auth_provider_uid', 'auth_key', 'password_hash'], 'string', 'max' => 255],
            [['store', 'user_id', 'zone'], 'unique', 'targetAttribute' => ['store', 'user_id', 'zone'], 'message' => 'The combination of Store, User ID and Zone has already been taken.']
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
            'zone' => Yii::t('base', 'Zone'),
            'auth_provider' => Yii::t('base', 'Auth Provider'),
            'auth_provider_uid' => Yii::t('base', 'Auth Provider Uid'),
            'auth_params' => Yii::t('base', 'Auth Params'),
            'auth_key' => Yii::t('base', 'Auth Key'),
            'password_hash' => Yii::t('base', 'Password Hash'),
            'login_attempts' => Yii::t('base', 'Login Attempts'),
            'recent_login' => Yii::t('base', 'Recent Login'),
            'recent_password_change' => Yii::t('base', 'Recent Password Change'),
            'status' => Yii::t('base', 'Status'),
        ];
    }
}
