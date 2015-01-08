<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;
use yii\web\IdentityInterface;
use gxc\yii2base\classes\TbActiveRecord;

/**
 * This is the model class for table "base_user_identity".
 *
 * @property string $id
 * @property string $store
 * @property integer $user_id
 * @property string $zone
 * @property string $auth_provider
 * @property string $auth_provider_uid
 * @property string $auth_params
 * @property string $auth_key
 * @property string $password_hash
 * @property string $recent_password_change
 * @property integer $status
 * 
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserIdentity extends TbActiveRecord implements IdentityInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 15;

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
            [['recent_password_change', 'auth_key', 'password_hash'], 'safe'],
            // [['user_id', 'status', 'recent_password_change'], 'integer'],
            [['user_id', 'status'], 'integer'],
            [['auth_params'], 'string'],            
            [['store', 'zone'], 'string', 'max' => 64],            
            [['store', 'user_id', 'zone'], 'unique', 'targetAttribute' => ['store', 'user_id', 'zone'], 'message' => 'User ID and Zone have already been taken.'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DISABLED]],
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
            'recent_password_change' => Yii::t('base', 'Recent Password Change'),
            'status' => Yii::t('base', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public function getBasic()
    {
        // User has_one User via User.id -> user_id
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProfile()
    {
        // User has_one User via UserProfile.user_id -> user_id and UserProfile.zone
        return $this->hasOne(UserProfile::className(), ['user_id' => 'user_id', 'zone' => 'zone']);
    }

    public function getDisplay()
    {
        // User has_one User via UserDisplay.user_id -> user_id and UserDisplay.zone
        return $this->hasOne(UserDisplay::className(), ['user_id' => 'user_id', 'zone' => 'zone']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email, $zone='site')
    {
        // First we have to find the user based on User Model      
        $user_model = \Yii::$app->tenant->createModel('User');  
        $user = $user_model::find()->asArray()->where(['email'=>$email])->one();
        if ($user) {                        
            return static::findOne(['user_id' => $user['id'], 'zone' => $zone, 'auth_provider' => 'app']);
        }
        return null;        
    }    

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    /**
     * Get User Status
     *
     * @return array
     */
    public static function getUserStatuses()
    {
        return [
            self::STATUS_DISABLED => Yii::t('base', 'Disabled'),
            self::STATUS_ACTIVE => Yii::t('base', 'Active'),
        ];
    }
}
