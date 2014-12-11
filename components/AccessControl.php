<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\components;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\di\Instance;
use yii\base\Module;

use gxc\yii2base\components\UserAuth;

/**
 *
 * Access Control Component. This is a behavior that can 
 * be attached to a controller
 * 
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class AccessControl extends \yii\base\ActionFilter
{
    /**
     * @var User User for check access.
     */
    public $user = '';
    
    /**
     * @var array List of action that not need to check access.
     */
    public $only = [];

    /**
     * @inheritdoc
     */
    public function init()
    {    	    	
        parent::init();               
        //$this->user = Instance::ensure($this->user, UserAuth::className());
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
    	echo 'VoAccess';
    	exit;        	

    	$module = $action->controller->module;
    	if (get_class($module) == 'yii\web\Application') {    		
    		$accessSpace = 'app';
    		if (\Yii::$app->tenant->isBackend) {
    			$accessSpace.=  '.admin';
    		} else {
    			$accessSpace.= '.site';    		
    		}
    	} elseif (isset($module->permissionId)) {
    		$accessSpace = $module->permissionId;
    	} else {
    		$accessSpace = $module->id;
    	}
    	
    	// echo 1;
    	// exit;
    	// var_dump($permissionName);
    	// exit;

    	// $permissionName = str_replace('/', '.', $action->controller->id).'.'.$action->getUniqueId();

    	//return true;
    	        
        //$this->denyAccess($user);
    }
}