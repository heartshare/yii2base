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
 * This is the model class for table "base_user_login".
 *
 * @property string $id
 * @property string $store
 * @property string $user_id
 * @property string $zone
 * @property string $login_at
 * @property integer $login_status
 * @property string $login_provider
 * @property integer $ip_address
 * 
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserLogin extends TbActiveRecord
{

    const FAILED_ACCOUNT_DISABLED = 0;
    const FAILED_WRONG_PASSWORD = 1;
    const FAILED_ACCOUNT_NOT_FOUND = 2;
    const SUCCESS = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_user_login';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'login_at'], 'required'],
            [['user_id', 'login_status', 'ip_address'], 'integer'],
            [['login_at'], 'safe'],
            [['user_agent'], 'string'],
            [['store', 'zone'], 'string', 'max' => 64],
            [['login_provider'], 'string', 'max' => 255]
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
            'login_at' => Yii::t('base', 'Login At'),
            'login_status' => Yii::t('base', 'Login Status'),
            'login_provider' => Yii::t('base', 'Login Provider'),
            'ip_address' => Yii::t('base', 'Ip Address'),
            'user_agent' => Yii::t('base', 'User Agent'),
        ];
    }
}
