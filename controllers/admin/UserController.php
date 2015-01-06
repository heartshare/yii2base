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

use gxc\yii2base\models\user\User;
use gxc\yii2base\models\user\UserDisplay;
use gxc\yii2base\models\user\UserProfile;
use gxc\yii2base\models\user\UserPermission;
use gxc\yii2base\models\user\UserSearch;
use gxc\yii2base\models\user\UserForm;
use gxc\yii2base\classes\BeController;
use gxc\yii2base\helpers\BaseHelper;

/**
 * User Controller of Base Module
 * 
 * This is the base user controller for app user CRUD
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UserController extends BeController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {        
        // Get zone roles
        $adminRoles = BaseHelper::getRolesFromFile(array('admin'));
        $siteRoles = BaseHelper::getRolesFromFile(array('site'));

        $staffZoneRoles = [];
        $guestZoneRoles = [];

        foreach ($adminRoles as $role => $detail) {
            $staffZoneRoles[$role] = $detail['description'];
        }
        
        foreach ($siteRoles as $role => $detail) {
            $guestZoneRoles[$role] = $detail['description'];
        }

        $tenantId = isset($_GET['tenant']) ? $_GET['tenant'] : \Yii::$app->tenant->current['id'];

        // Get model
        $model = \Yii::$app->tenant->createModel('UserForm');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Save User info
            $user = \Yii::$app->tenant->createModel('User');
            $user->attributes = $model->attributes;
            if ($user->save()) {
                // Save additional information
                $this->afterSaveUserInfo($user->id, $model);

                Yii::$app->session->setFlash('message', ['success', Yii::t('base', 'Create User Successfully.')]);
                return $this->redirect(['update', 'id' => $user->id]);
            } else {
                var_dump($user->getErrors());
                // throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'tenantId' => $tenantId,
                    'staffZoneRoles' => $staffZoneRoles,
                    'guestZoneRoles' => $guestZoneRoles,
                ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        // Get zone roles
        $adminRoles = BaseHelper::getRolesFromFile(array('admin'));
        $siteRoles = BaseHelper::getRolesFromFile(array('site'));
        $staffZoneRoles = [];
        $guestZoneRoles = [];
        foreach ($adminRoles as $role => $detail) {
            $staffZoneRoles[$role] = $detail['description'];
        }
        foreach ($siteRoles as $role => $detail) {
            $guestZoneRoles[$role] = $detail['description'];
        }

        $tenantId = isset($_GET['tenant']) ? $_GET['tenant'] : \Yii::$app->tenant->current['id'];

        $identity = isset($_GET['identity']) ? $_GET['identity'] : null;
        if ($identity && in_array($identity, ['staff', 'guest'])) {
            // Get model
            $model = \Yii::$app->tenant->createModel('UserForm');
            $user = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->zone == $user->identityInfo->zone) {
                    $user->attributes = $model->attributes;
                    if ($user->save()) {
                        // Save additional information
                        $this->afterSaveUserInfo($user->id, $model, $model->zone);

                        Yii::$app->session->setFlash('message', ['success', Yii::t('base', 'Update User Successfully.')]);
                    } else {
                        // var_dump($user->getErrors());
                        throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));
                    }
                }
            } else {
                // Load attribute to model
                if ($user) {
                    $model->attributes = $user->attributes;
                    $model->first_name = isset($user->profileInfo->first_name) ? $user->profileInfo->first_name : '';
                    $model->last_name = isset($user->profileInfo->last_name) ? $user->profileInfo->last_name : '';
                    $model->location = isset($user->profileInfo->location) ? $user->profileInfo->location : '';
                    $model->timezone = isset($user->profileInfo->timezone) ? $user->profileInfo->timezone : '';
                    $model->birthdate = isset($user->profileInfo->birthday) ? \Yii::$app->locale->toUTCTime($user->profileInfo->birthday, 'Y-m-d', 'd-m-Y') : '';
                    $model->bio = isset($user->profileInfo->bio) ? $user->profileInfo->bio : '';
                    $model->screen_name = isset($user->displayInfo->screen_name) ? $user->displayInfo->screen_name : '';
                    $model->display_name = isset($user->displayInfo->display_name) ? $user->displayInfo->display_name : '';
                    $model->password = isset($user->identityInfo->password_hash) ? $user->identityInfo->password_hash : '';
                    $model->status = isset($user->identityInfo->status) ? $user->identityInfo->status : '';
                    $model->zone = isset($user->identityInfo->zone) ? $user->identityInfo->zone : '';
                    $identity .= '_zone';
                    $model->$identity = isset($user->permissionInfo->item_name) ? $user->permissionInfo->item_name : '';
                }
            }

            return $this->render('update', [
                        'model' => $model,
                        'tenantId' => $tenantId,
                        'staffZoneRoles' => $staffZoneRoles,
                        'guestZoneRoles' => $guestZoneRoles,
                    ]);
        } else {
            throw new NotFoundHttpException(Yii::t('base', 'User Identity is not existed.'));
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // Delete relational user information
        $this->afterDeleteUserInfo($id);

        return $this->redirect(['admin/auth/index', 'type' => 'user']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelClass = \Yii::$app->tenant->getModel('User', 'class');
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Save additional user information: User profile and User display
     *
     * @param $model
     */
    protected function afterSaveUserInfo($id, $model, $zone)
    {
        // Assign role for user
        $elementZone = $zone . '_zone';
        if (isset($model->$elementZone)) {
            $userPermission = \Yii::$app->tenant->createModel('UserPermission')->findOne(['user_id' => $id]);
            if (empty($userPermission)) {
                $userPermission = \Yii::$app->tenant->createModel('UserPermission');
            }
            $userPermission->store = $model->store;
            $userPermission->user_id = $id;
            $userPermission->item_name = $model->$elementZone;
            $userPermission->date_created = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
            $userPermission->save();
        }

        // Create - Update UserIdentity
        $userIdentity = \Yii::$app->tenant->createModel('UserIdentity')->findOne(['user_id' => $id]);
        if (empty($userIdentity)) {
            $userIdentity = \Yii::$app->tenant->createModel('UserIdentity');
        }

        $userIdentity->store = $model->store;
        $userIdentity->user_id = $id;
        $userIdentity->zone = $model->zone;
        $userIdentity->setPassword($model->password);
        $userIdentity->generateAuthKey();
        $userIdentity->status = $model->status;
        $userIdentity->save();

        // Create - Update UserProfile
        $userProfile = \Yii::$app->tenant->createModel('UserProfile')->findOne(['user_id' => $id]);
        if (empty($userProfile)) {
            $userProfile = \Yii::$app->tenant->createModel('UserProfile');
            $userProfile->registered_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
        }

        $userProfile->store = $model->store;
        $userProfile->user_id = $id;
        $userProfile->zone = $model->zone;
        $userProfile->gender = $model->gender;
        $userProfile->first_name = $model->first_name;
        $userProfile->last_name = $model->last_name;
        $userProfile->location = $model->location;
        $userProfile->timezone = $model->timezone;
        $userProfile->birthday = !empty($model->birthdate) ? \Yii::$app->locale->toUTCTime($model->birthdate, 'd-m-Y', 'Y-m-d') : null;
        $userProfile->bio = $model->bio;
        $userProfile->save();

        // Create - Update UserDisplay
        $userDisplay = \Yii::$app->tenant->createModel('UserDisplay')->findOne(['user_id' => $id]);
        if (empty($userDisplay)) {
            $userDisplay = \Yii::$app->tenant->createModel('UserDisplay');
        }

        $userDisplay->store = $model->store;
        $userDisplay->user_id = $id;
        $userDisplay->zone = $model->zone;
        $userDisplay->screen_name = $model->screen_name;
        $userDisplay->display_name = $model->display_name;
        $userDisplay->save();
    }

    /**
     * Delete relational user information
     *
     * @param $model
     */
    protected function afterDeleteUserInfo($id)
    {
        // Delete User Permission
        $userPermission = \Yii::$app->tenant->createModel('UserPermission')->findOne(['user_id' => $id]);
        if (!empty($userPermission)) {
            $userPermission->delete();
        }

        // Delete UserIdentity
        $userIdentity = \Yii::$app->tenant->createModel('UserIdentity')->findOne(['user_id' => $id]);
        if (!empty($userIdentity)) {
            $userIdentity->delete();
        }

        // Delete UserProfile
        $userProfile = \Yii::$app->tenant->createModel('UserProfile')->findOne(['user_id' => $id]);
        if (!empty($userProfile)) {
            $userProfile->delete();
        }

        // Delete UserDisplay
        $userDisplay = \Yii::$app->tenant->createModel('UserDisplay')->findOne(['user_id' => $id]);
        if (!empty($userDisplay)) {
            $userDisplay->delete();
        }
    }
}
