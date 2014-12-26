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
use yii\helpers\FileHelper;

use gxc\yii2base\classes\BeController;
use gxc\yii2base\helpers\BaseHelper;

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
            $tenantStore = '';
            if ($store !== false && $store != '') {
                $tenantStore = $tenant->$store;
            }

            // Load all roles from permission file
            $roles = BaseHelper::getRolesByTenant($tenantId, $tenantStore);

            // Find the Module which is from current Tenant
            $arrCondition = ['store' => $tenant->$store, 'module' => $moduleId];
            $currentModule = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->one();
            
            return $this->render('index', [
                'tenantId' => $tenantId,
                'currentModule' => $currentModule,
                'tenant' => $tenant,
                'roles' => $roles
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Assign Role
     * 
     * @return mixed
     */
    public function actionAssign()
    {
        if (isset($_GET['id'])) {
            $role = $_GET['id'];
            $moduleId = isset($_GET['module']) ? $_GET['module'] : 'app';       
            $tenantId = isset($_GET['tenant']) ? $_GET['tenant'] : \Yii::$app->tenant->current['id'];     

            $tenant = false;
            $currentModule = false;
            $modules = false;
            $roleName = '';

            // Need to check on this for Data Store
            $tenant = \Yii::$app->tenant->createModel('Tenant')->findOne($tenantId);

            if ($tenant) {
                $store = \Yii::$app->tenant->getModel('TenantModule', 'store');
                $tenantStore = '';
                if ($store !== false && $store != '') {
                    $tenantStore = $tenant->$store;
                }

                // Get all modules   
                $arrCondition = ['store' => $tenantStore];
                $modules = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->all(); 

                // Load all roles from permission file
                $permissions = BaseHelper::getPermissionsByTenant($tenantId, $tenantStore);

                // Get permission items by current module
                $currentPermissions = isset($permissions[$moduleId]) ? $permissions[$moduleId] : [];

                $rolePermissions = [];
                if (!empty($currentPermissions)) {
                    foreach ($currentPermissions as $region => $permission) {
                        if ($region == 0) {
                            $region = 'admin';
                        } else {
                            $region = 'site';
                        }

                        // Get all permission items of module
                        if (isset($permission['items'])) {
                            foreach ($permission['items'] as $item => $detail) {
                                // Get the controller of action
                                $rolePermissions[$region][$item]['controller'] = '';
                                $temp = explode('.', $item);
                                if (isset($temp[0])) {
                                    $rolePermissions[$region][$item]['controller'] = $temp[0];

                                    if ($temp[1] != '*') {
                                        $rootAction = $temp[0] . '.*';
                                        if (isset($rolePermissions[$region][$rootAction])) {
                                            $rolePermissions[$region][$rootAction]['children'][] = $item;
                                        }
                                    }
                                }

                                // Get the description of permission item
                                $rolePermissions[$region][$item]['description'] = $detail['description'];
                            }
                        }

                        // Set active for items assigned to role
                        if (isset($permission['roles'][$role]['children'])) {
                            $roleName = $permission['roles'][$role]['description'];
                            $assignRoles = $permission['roles'][$role]['children'];
                            foreach ($assignRoles as $assignRole) {
                                if (isset($permission['items'][$assignRole])) {
                                    $rolePermissions[$region][$assignRole]['check'] = 1;

                                    // If item is root action, set active for all actions of this controller
                                    $temp = explode('.', $assignRole);
                                    if (isset($temp[1]) && $temp[1] == '*') {
                                        if (isset($rolePermissions[$region][$assignRole]['children'])) {
                                            foreach ($rolePermissions[$region][$assignRole]['children'] as $childRole) {
                                                $rolePermissions[$region][$childRole]['check'] = 1;
                                            }
                                        }
                                    }
                                } else {
                                    $rolePermissions[$region][$assignRole]['check'] = '-1';
                                }
                            }
                        }
                    }
                }

                $arrCondition = ['store' => $tenant->$store, 'module' => $moduleId];
                $currentModule = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->one();

                // Find the Module which is from current Tenant
                return $this->render('assign', [
                    'tenantId' => $tenantId,
                    'modules' => $modules,
                    'currentModule' => $currentModule,
                    'tenant' => $tenant,
                    'roleName' => $roleName,
                    'rolePermissions' => $rolePermissions
                ]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
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
