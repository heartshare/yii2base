<?php

namespace gxc\yii2base\classes;

use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;

/**
 * Backend Wrapper Controller for App Module
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since 2.0
 */
class BeController extends \yii\web\Controller
{
	// temp code to prevent error when submit
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['login', 'error'],
						'allow' => true,
						'roles' => ['?']
					],
					[
						// 'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			]
		];
	}

	public function beforeAction($action)
    {
    	if (parent::beforeAction($action)) {
            $module = $action->controller->module;
	    	if (get_class($module) == 'yii\web\Application') {    		
	    		$accessSpace = 'app';
	    		if (\Yii::$app->tenant->isBackend) {
	    			$accessSpace.=  '.admin';
	    		} else {
	    			$accessSpace.= '.site';    		
	    		}
	    	} elseif (isset($module->uniqueId)) {
	    		$accessSpace = $module->uniqueId;
	    	} else {
	    		$accessSpace = $module->id;
	    	}

	    	$permissionName = $accessSpace.'.'.str_replace('/', '.',$action->controller->id).'.'.$action->id;

	    	//  Start to check the permission
	    	//  
            return true;  // or false if needed
        } else {
            return false;
        }
    }
}