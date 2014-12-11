<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\controllers\admin;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use gxc\yii2base\classes\BeController;


/**
 * Auth Controller of Base Module
 * 
 * This is the controller to manage Permission Items, Roles, Rules 
 * and Assignments
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class AuthController extends BeController
{      

    /**
     * Lists all Tenant models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$module = isset($_GET['module']) ? $_GET['module'] : 'app';    	
    	
    	// Get Tenant Module information
    	$tenantModuleModel = \Yii::$app->tenant->createModel('TenantModule');
        
        // Find the Module which is from current Tenant
        return $this->render('index', [
                //'model' => $model,
            ]);


    }

    /**
     * Build Module Permission
     * 
     * @return mixed
     */
    public function actionBuild()
    {
        
    }

}
