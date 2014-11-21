<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Application;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

use gxc\yii2base\helpers\BaseHelper;


/** 
 * Backend Config Behavior. 
 * This behavior prepare and setup basic information of the tenant, locale, etc.
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class BackendConfigBehavior extends Behavior
{

	public $rootTenant = 1;

	public $multiTenants = false;

	/**
	 * @inheritdoc
	 */
	public function events()
	{
		return [
			Application::EVENT_BEFORE_REQUEST => [$this, 'beforeRequest'],
			Application::EVENT_AFTER_REQUEST => [$this, 'afterRequest'],
		];
	}

	/**
	 * Make sure that the current Base Module Zone is backend 
	 * and set the tenant current and root info to by getting the
	 * Root Tenant ID setted in Base Module
	 * 
	 * @throws InvalidConfigException if no root tenant is found
	 */
	public function beforeRequest()
	{		
		$rootTenant = BaseHelper::getTenant($this->rootTenant);		
		if ($rootTenant) {			
			\Yii::$app->tenant->isBackend = true;
			\Yii::$app->tenant->current = \Yii::$app->tenant->root = $rootTenant;
		} else {
			throw new InvalidConfigException(Yii::t('base', 'No Root Tenant Found'));
		}					
		return;
	}

	/**
	 * @inheritdoc
	 */
	public function afterRequest()
	{
		return true;
	}

}
