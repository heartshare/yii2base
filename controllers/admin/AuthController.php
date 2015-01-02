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
 * @author  Triet Nguyen <minhtriet1989@gmail.com>
 * @since  2.0
 */
class AuthController extends BeController
{      

    /**
     * List all Roles of Tenant
     * If Tenant id is empty, get Tenant root
     *
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
            // Get store of Tenant Module
            $store = \Yii::$app->tenant->getModel('TenantModule', 'store');

            // Load all roles from permission file
            $roles = BaseHelper::getRolesFromFile();

            // Find the Module which is from current Tenant
            $arrCondition = ['store' => $tenant->$store, 'module' => $moduleId];
            $currentModule = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->one();

            // Get all users
            $users = \Yii::$app->tenant->createModel('User')->find()->all();

            return $this->render('index', [
                'currentModule' => $currentModule,
                'tenant' => $tenant,
                'roles' => $roles,
                'users' => $users
            ]);
        } else {
            throw new NotFoundHttpException(\Yii::t('base','The requested page does not exist.'));
        }
    }

    /**
     * Assign Permissions to specific Role or User
     * 
     * @return mixed
     */
    public function actionAssign()
    {
        if (isset($_GET['id'])) {
            $role = $_GET['id'];

            $type = isset($_GET['type']) ? $_GET['type'] : 'role';

            // In case permissions are assigned to user, get user permission to know user of role
            $userPermission = [];
            if ($type == 'user') {
                $userPermissionModel = \Yii::$app->tenant->createModel('UserPermission')->findOne(['user_id' => $_GET['id']]);
                if (isset($userPermissionModel->item_name) && $userPermissionModel->item_name) {
                    $userPermission = unserialize($userPermissionModel->item_name);
                    $userPermission = array_combine(['admin', 'site'], array_values($userPermission));
                }
            }

            $moduleId = isset($_GET['module']) ? $_GET['module'] : 'app';       
            $tenantId = isset($_GET['tenant']) ? $_GET['tenant'] : \Yii::$app->tenant->current['id'];     

            $tenant = false;
            $currentModule = false;
            $modules = false;

            $tenant = \Yii::$app->tenant->createModel('Tenant')->findOne($tenantId);

            if ($tenant) {
                $store = \Yii::$app->tenant->getModel('TenantModule', 'store');
                $tenantStore = '';
                if ($store !== false && $store != '') {
                    $tenantStore = $tenant->$store;
                }

                // Get all modules   
                $modules = \Yii::$app->tenant->createModel('TenantModule')->findAll(['store' => $tenantStore]); 

                // Get current module
                foreach ($modules as $module) {
                    if ($module->module == $moduleId) {
                        $currentModule = $module;
                    }
                }

                // Load all permissions
                // First get from database, if empty, get from permission files
                if (!empty($currentModule->permissions)) {
                    $rolePermissions = unserialize($currentModule->permissions);
                } else {
                    $permissions = BaseHelper::getPermissionsFromFile();
                    $rolePermissions = isset($permissions[$moduleId]) ? $permissions[$moduleId] : [];
                }

                // Get role name or user name
                $name = '';
                if ($type == 'role') {
                    $roles = BaseHelper::getRolesFromFile();
                    $name = isset($roles[$role]['description']) ? $roles[$role]['description'] : '';
                }

                if ($type == 'user') {
                    $user = \Yii::$app->tenant->createModel('UserDisplay')->findOne(['user_id' => $_GET['id']]);
                    if (!empty($user)) {
                        $name = $user->display_name;
                    }
                }

                if (isset($_POST['permissionStatus']) && !empty($_POST['permissionStatus'])) {
                    foreach ($_POST['permissionStatus'] as $region => $postPermissions) {
                        // In case permissions are assigned to user, get corresponding role
                        if ($type == 'user' && !empty($userPermission)) {
                            $role = isset($userPermission[$region]) ? $userPermission[$region] : $role;
                        }

                        foreach ($postPermissions as $itemName => $status) {
                            if ($type == 'user') {
                                if ((isset($rolePermissions[$region][$itemName]['users']) && !in_array($_GET['id'], $rolePermissions[$region][$itemName]['users'])) || !isset($rolePermissions[$region][$itemName]['users'])) {
                                    if ((isset($rolePermissions[$region][$itemName]['roles']) && !in_array($role, $rolePermissions[$region][$itemName]['roles'])) || !isset($rolePermissions[$region][$itemName]['roles'])) {
                                        $rolePermissions[$region][$itemName]['users'][] = $_GET['id'];
                                    }
                                }
                            }

                            if ($type == 'role') {
                                if ((isset($rolePermissions[$region][$itemName]['roles']) && !in_array($role, $rolePermissions[$region][$itemName]['roles'])) || !isset($rolePermissions[$region][$itemName]['roles'])) {
                                    $rolePermissions[$region][$itemName]['roles'][] = $role;
                                }
                            }
                        }
                    }

                    // Remove permission inactive out of a role
                    foreach ($rolePermissions as $region => $itemPermissions) {
                        foreach ($itemPermissions as $itemName => $detail) {
                            if ($type == 'user') {
                                if (array_key_exists('users', $detail)) {
                                    if (!isset($_POST['permissionStatus'][$region][$itemName])) {
                                        $key = array_search($_GET['id'], $detail['users']);
                                        if ($key !== false) {
                                            unset($rolePermissions[$region][$itemName]['users'][$key]);
                                        }
                                    }
                                }
                            }

                            if ($type == 'role') {
                                if (array_key_exists('roles', $detail)) {
                                    if (!isset($_POST['permissionStatus'][$region][$itemName])) {
                                        $key = array_search($role, $detail['roles']);
                                        if ($key !== false) {
                                            unset($rolePermissions[$region][$itemName]['roles'][$key]);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // Update Permission to database
                    if (empty($currentModule)){
                        $currentModule = new TenantModule();
                        $currentModule->registered_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
                    }

                    $currentModule->store = $tenantStore;
                    $currentModule->permissions = serialize($rolePermissions);
                    $currentModule->updated_by = Yii::$app->user->info('id');
                    $currentModule->updated_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
                    if ($currentModule->save() == 1) {
                         Yii::$app->session->setFlash('message', ['success', 'Update Permissions Successfully.']);
                    } else {
                         Yii::$app->session->setFlash('message', ['error', 'Update Permissions Failed.']);
                    }
                }

                echo '<pre>';
                var_dump($rolePermissions);
                echo '</pre>';

                // Get additional information permission items
                foreach ($rolePermissions as $region => $itemPermissions) {
                    // In case permissions are assigned to user, get corresponding role
                    if ($type == 'user' && !empty($userPermission)) {
                        $role = isset($userPermission[$region]) ? $userPermission[$region] : $role;
                    }

                    foreach ($itemPermissions as $itemName => $detail) {
                        // Get controller of action
                        $temp = explode('.', $itemName);
                        $detail['controller'] = isset($temp[0]) ? ucfirst($temp[0]) : '';

                        // Set active for assign roles
                        if ($role == 'superAdmin' || (isset($detail['roles']) && in_array($role, $detail['roles']))) {
                            $detail['check'] = 1;
                        }

                        if ($type == 'user' && isset($detail['users']) && in_array($_GET['id'], $detail['users'])) {
                            $detail['check'] = 1;
                        }

                        $itemPermissions[$itemName] = $detail;
                    }
                    $rolePermissions[$region] = $itemPermissions;
                }

                return $this->render('assign', [
                    'tenantId' => $tenantId,
                    'modules' => $modules,
                    'currentModule' => $currentModule,
                    'tenant' => $tenant,
                    'name' => $name,
                    'rolePermissions' => $rolePermissions
                ]);
            } else {
                throw new NotFoundHttpException(\Yii::t('base','The requested page does not exist.'));
            }
        } else {
            throw new NotFoundHttpException(\Yii::t('base','The requested page does not exist.'));
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