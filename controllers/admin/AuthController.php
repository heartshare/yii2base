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
    	$moduleId = isset($_GET['module']) ? $_GET['module'] : 'app';    	
        $tenantId = isset($_GET['tenant']) ? $_GET['tenant'] : \Yii::$app->tenant->current['id'];     
    	
        $tenant = false;
        $currentModule = false;
        $modules = false;
        // Need to check on this for Data Store
        $tenant = \Yii::$app->tenant->createModel('Tenant')->findOne($tenantId);

        if ($tenant) {
            $store = \Yii::$app->tenant->getModel('TenantModule', 'store');     
            $arrCondition = [];
            if ($store!==false && $store!='') {
                $arrCondition = ['store' => $tenant->$store];                
            }

            $modules = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->all();

            $arrCondition= ['store' => $tenant->$store, 'module' => $moduleId];
            $currentModule = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->one();

            // Find the Module which is from current Tenant
            return $this->render('index', [                
                'currentModule' => $currentModule,
                'modules' => $modules,
                'tenant' => $tenant,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        
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
