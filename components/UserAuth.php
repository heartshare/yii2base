<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\User;

/**
 *
 * User Auth Component
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserAuth extends User
{

	/**
	 * Initializes the application component.
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * Return user information based on attr. This function get information from
	 * user current session
	 * @param  [mixed] $attr [Attribute of the user info we want to get]
	 * @return [mixed]       [User attribute value]
	 */
	public function info($attr=null)
	{
		$info = \Yii::$app->session->get('userInfo');
		if ($info) {
			if ($attr && isset($info[$attr])) {
				return $info[$attr];
			} else {
				return $info;
			}
		}		
		return null;
	}

	/**
	 * After Login, we retrieve the user information from the 
	 * DB and then set some general info into session for later retrieving
	 * @param  mixed $identity    identity information
	 * @param  boolean $cookieBased Is this a cookie based login
	 * @param  mixed $duration How long do we want the user stay logged in 
	 */
	protected function afterLogin($identity, $cookieBased, $duration)
	{
		parent::afterLogin($identity, $cookieBased, $duration);
		$id = $identity->getId();

		// Get User Information from User Display Table				
		$userDisplayModel = \Yii::$app->tenant->createModel('UserDisplay');		
		$userDisplay = $userDisplayModel::find()->asArray()->where(['user_id' => $id])->one();
		if ($userDisplay) {				
			\Yii::$app->session->set('userInfo', $userDisplay);
		}
		
	}
}
