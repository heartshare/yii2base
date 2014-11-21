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
use yii\web\NotFoundHttpException;

/** 
 * Frontend Config Behavior. 
 * This behavior prepare and setup basic information of the tenant, locale, and etc.
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class BackendConfigBehavior extends Behavior
{
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
	 * @inheritdoc
	 */
	public function beforeRequest()
	{		
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
