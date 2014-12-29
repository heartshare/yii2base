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
use gxc\yii2base\models\tenant\TenantForm;

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
            if (isset($_GET['type']) && $_GET['type'] == 'user') {
                $type = 'users';
            } else {
                $type = 'roles';
            }

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

                // Get current module
                $arrCondition = ['store' => $tenant->$store, 'module' => $moduleId];
                $currentModule = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->one();

                // Load all roles and permissions
                // First get from database, if null, get from permission file
                if (!empty($currentModule->permissions)) {
                    $rolePermissions = unserialize($currentModule->permissions);
                } else {
                    $permissions = BaseHelper::getPermissionsFromFile($tenantId, $tenantStore);
                    $rolePermissions = isset($permissions[$moduleId]) ? $permissions[$moduleId] : [];
                }

                // echo '<pre>';
                // var_dump($rolePermissions);
                // echo '</pre>';

                // Update Permission to database
                if (isset($_POST['permissionStatus']) && !empty($_POST['permissionStatus'])) {
                    foreach ($_POST['permissionStatus'] as $region => $postPermissions) {
                        foreach ($postPermissions as $itemName => $status) {
                            if ((isset($rolePermissions[$region][$itemName][$type]) && !in_array($role, $rolePermissions[$region][$itemName][$type])) || !isset($rolePermissions[$region][$itemName][$type])) {
                                $rolePermissions[$region][$itemName][$type][] = $role;
                            }
                        }
                    }

                    // Remove permission inactive out of a role
                    foreach ($rolePermissions as $region => $itemPermissions) {
                        foreach ($itemPermissions as $itemName => $detail) {
                            if (array_key_exists($type, $detail)) {
                                if (!isset($_POST['permissionStatus'][$region][$itemName])) {
                                    $key = array_search($role, $detail[$type]);
                                    if ($key !== false) {
                                        unset($rolePermissions[$region][$itemName][$type][$key]);
                                    }
                                }
                            }
                        }
                    }

                    if (empty($currentModule)){
                        $currentModule = new TenantModule();
                        $currentModule->store = $tenantStore;
                        $currentModule->updated_by = Yii::$app->user->info('id');
                        $currentModule->registered_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
                        $currentModule->save();
                    } else {
                        $currentModule->permissions = serialize($rolePermissions);
                        $currentModule->updated_by = Yii::$app->user->info('id');
                        $currentModule->updated_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
                        if ($currentModule->save() == 1) {
                             Yii::$app->session->setFlash('message', ['success', 'Update Permissions Successfully.']);
                        } else {
                             Yii::$app->session->setFlash('message', ['error', 'Update Permissions Failed.']);
                        }
                    }
                }

                // Get additional information permission items
                foreach ($rolePermissions as $region => $itemPermissions) {
                    foreach ($itemPermissions as $itemName => $detail) {
                        // Get controller of action
                        $temp = explode('.', $itemName);
                        $detail['controller'] = isset($temp[0]) ? ucfirst($temp[0]) : '';

                        // Set active for assign roles
                        if (isset($detail[$type]) && in_array($role, $detail[$type])) {
                            $detail['check'] = 1;
                        }

                        $itemPermissions[$itemName] = $detail;
                    }
                    $rolePermissions[$region] = $itemPermissions;
                }

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
