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
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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

        // Get model
        $model = \Yii::$app->tenant->createModel('UserForm');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Save User info
            $user = $this->findModel($id);
            $user->attributes = $model->attributes;
            if ($user->save()) {
                // Save additional information
                $this->afterSaveUserInfo($user->id, $model);

                Yii::$app->session->setFlash('message', ['success', Yii::t('base', 'Update User Successfully.')]);
                // return $this->redirect(['update', 'id' => $user->id]);
            } else {
                // var_dump($user->getErrors());
                throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));
            }
        } else {
            // Load attribute to model
            $user = $this->findModel($id);
            if ($user) {
                if (isset($user->permissionInfo)) {
                    $userPermission = unserialize($user->permissionInfo->item_name);
                }

                $model->attributes = $user->attributes;
                $model->first_name = isset($user->profileInfo->first_name) ? $user->profileInfo->first_name : '';
                $model->last_name = isset($user->profileInfo->last_name) ? $user->profileInfo->last_name : '';
                $model->screen_name = isset($user->displayInfo->screen_name) ? $user->displayInfo->screen_name : '';
                $model->display_name = isset($user->displayInfo->display_name) ? $user->displayInfo->display_name : '';
                $model->zone = isset($user->identityInfo->zone) ? $user->identityInfo->zone : '';
                $model->staff_zone = isset($userPermission['staff']) ? $userPermission['staff'] : '';
                $model->guest_zone = isset($userPermission['guest']) ? $userPermission['guest'] : '';
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'staffZoneRoles' => $staffZoneRoles,
                    'guestZoneRoles' => $guestZoneRoles,
                ]);
    }

    /**
     * Save additional user information: User profile and User display
     *
     * @param $model
     */
    protected function afterSaveUserInfo($id, $model)
    {
        // Assign role for user
        $userPermission = \Yii::$app->tenant->createModel('UserPermission')->find()->where(['user_id' => $id])->one();
        if (empty($userPermission)) {
            $userPermission = \Yii::$app->tenant->createModel('UserPermission');
        }
        $assignRole = [];
        if (isset($model->staff_zone) && !empty($model->staff_zone)) {
            $assignRole['staff'] = $model->staff_zone;
        }
        if (isset($model->guest_zone) && !empty($model->guest_zone)) {
            $assignRole['guest'] = $model->guest_zone;
        }
        $userPermission->store = $model->store;
        $userPermission->user_id = $id;
        $userPermission->item_name = serialize($assignRole);
        $userPermission->date_created = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
        $userPermission->save();

        // Create - Update UserIdentity
        $userIdentity = \Yii::$app->tenant->createModel('UserIdentity')->find()->where(['user_id' => $id])->one();
        if (empty($userIdentity)) {
            $userIdentity = \Yii::$app->tenant->createModel('UserIdentity');
        }

        $userIdentity->store = $model->store;
        $userIdentity->user_id = $id;
        $userIdentity->zone = $model->zone;
        $userIdentity->save();

        // Create - Update UserProfile
        $userProfile = \Yii::$app->tenant->createModel('UserProfile')->find()->where(['user_id' => $id])->one();
        if (empty($userProfile)) {
            $userProfile = \Yii::$app->tenant->createModel('UserProfile');
        }

        $userProfile->store = $model->store;
        $userProfile->user_id = $id;
        $userProfile->zone = $model->zone;
        $userProfile->gender = $model->gender;
        $userProfile->first_name = $model->first_name;
        $userProfile->last_name = $model->last_name;
        $userProfile->location = $model->location;
        $userProfile->birthday = $model->birthdate;
        $userProfile->save();

        // Create - Update UserDisplay
        $userDisplay = \Yii::$app->tenant->createModel('UserDisplay')->find()->where(['user_id' => $id])->one();
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}
