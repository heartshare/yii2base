<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\models\user;

use Yii;
use yii\base\Model;

/**
 * Backend Login form. Find User by Email and validate Password
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class BackendLoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method also log login activities for security checking
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser(); 
            $userLogin = \Yii::$app->tenant->createModel('UserLogin');             	
            $userLogin->login_provider = 'app';
            $userLogin->user_id = 0;

            if ($user) {
            	$userIdentity = \Yii::$app->tenant->createModel('UserIdentity');            	            	
            	$userLogin->user_id = $user->user_id;
            	

            	if (!($user->status == $userIdentity::STATUS_ACTIVE)) {            		            		
            		$userLogin->login_status = $userLogin::FAILED_ACCOUNT_DISABLED;
            		$this->addError('email', \Yii::t('base','Account is disabled.'));

            	} elseif (!$user->validatePassword($this->password)) {
            		$userLogin->login_status = $userLogin::FAILED_WRONG_PASSWORD;
            		$this->addError('password', \Yii::t('base','Incorrect email or password.'));	
            	} else {
            		$userLogin->login_status = $userLogin::SUCCESS;
            	}
            } else {
            	$userLogin->login_status = $userLogin::FAILED_ACCOUNT_NOT_FOUND;
            	$this->addError('password', \Yii::t('base','Incorrect email or password.'));	
            }   

            $userLogin->zone = 'staff';            		            
            $userLogin->ip_address = ip2long(\Yii::$app->request->userIP);
            $userLogin->user_agent = \Yii::$app->request->userAgent;
            $userLogin->login_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');            
            $userLogin->save();  

        }
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {    	            
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {                
            return false;
        }
    }

    /**
     * Finds user by email
     *
     * @return mixed user object or null
     */
    public function getUser()
    {
    	$userModel = \Yii::$app->tenant->createModel('UserIdentity');
        if ($this->_user === false) {
            $this->_user = $userModel::findByEmail($this->email, 'staff');
        }
        return $this->_user;
    }
}
