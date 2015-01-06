<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\controllers\admin;

use gxc\yii2base\models\tenant\TenantModule;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use gxc\yii2base\classes\BeController;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Tenant Controller of Base Module
 *
 * This is the base Tenant controller
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since  2.0
 */
class TenantController extends BeController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

    /**
     * Lists all Tenant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = \Yii::$app->tenant->createModel('TenantSearch');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Tenant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = \Yii::$app->tenant->createModel('TenantForm');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // save tenant info
            $tenant = \Yii::$app->tenant->createModel('Tenant');
            $tenant->attributes = $model->attributes;
            if ($tenant->save()) {

                // save additional information
                $this->afterSaveTenantInfo($model, $tenant);

                // flash successfully
                Yii::$app->session->setFlash('message', ['success', Yii::t('base', 'Create New Tenant Successfully.')]);
                return $this->redirect(['view', 'id' => $tenant->id]);
            } else {
                throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tenant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = \Yii::$app->tenant->createModel('TenantForm');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // save tenant info
            $tenant = $this->findModel($id);
            $tenant->attributes = $model->attributes;
            if ($tenant->save()) {

                // save additional information
                $this->afterSaveTenantInfo($model, $tenant);

                // flash successfully
                Yii::$app->session->setFlash('message', ['success', 'Update Tenant Successfully.']);
                return $this->redirect(['update', 'id' => $tenant->id]);
            } else {
                throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));
            }
        } else {
            // load attribute to model
            $tenant = $this->findModel($id);
            $model->attributes = $tenant->attributes;
            $model->email = $tenant->account->email;

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * save additional tenant information: user and tenant profile
     *
     * @param $model
     * @param $tenant
     */
    protected function afterSaveTenantInfo($model, $tenant)
    {
        // create user if not exist
        $userClass = \Yii::$app->tenant->createModel('User');
        $user = $userClass::findOne(['email' => $model->email, 'store' => $model->app_store]);
        if (empty($user)) {
            $user = \Yii::$app->tenant->createModel('User');
            $user->email = $model->email;
            $user->store = $tenant->app_store;
            if($user->save()){
                // create user display
                $userDisplay = \Yii::$app->tenant->createModel('UserDisplay');
                $userDisplay->store = $user->store;
                $userDisplay->user_id = $user->id;
                $userDisplay->display_name = $userDisplay->screen_name = Yii::t('base', 'Unknown');
                $userDisplay->save();
            }
        }

        // create tenant profile if not exist
        $tenantProfileClass = \Yii::$app->tenant->createModel('TenantProfile');
        $tenantProfile = $tenantProfileClass::findOne(['store' => $model->app_store]);
        if (empty($tenantProfile) && !empty($user->id)) {
            $tenantProfile = $tenantProfileClass;
            $tenantProfile->store = $tenant->app_store;
            $tenantProfile->user_registered_id = $user->id;
            $tenantProfile->registered_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
            $tenantProfile->save();
        // save new owner user info
        } else {
            $tenantProfile->user_registered_id = $user->id;
            $tenantProfile->save();
        }
    }

    /**
     * Deletes an existing Tenant model.
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
     * view a tenant with id
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('tabs', [
            'mode' => 'view',
            'model' => $model,
        ]);
    }

    /**
     * Finds the Tenant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tenant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $tenantClass = \Yii::$app->tenant->createModel('Tenant');

        if (($model = $tenantClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));
        }
    }

    /**
     * update tenant contact information
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionContactUpdate($id)
    {
        $model = $this->findModel($id);

        $contact = Yii::$app->tenant->createModel('TenantContactForm');
        $addressClass = Yii::$app->tenant->createModel('Address');

        //load from db if exist
        $address = $addressClass::findOne(['id' => $model->profile->address_registered_id]);

        if ($contact->load(Yii::$app->request->post()) && $contact->validate()) {

            $isNew = false;
            if (empty($address)) {
                $address = $addressClass;
                $isNew = true;
            }
            $address->store = $model->app_store;
            $address->first_name = $contact->first_name;
            $address->last_name = $contact->last_name;
            $address->email = $contact->email;
            $address->company = $contact->company_name;
            $address->alias = (string)$addressClass::ALIAS_ADDRESS_1; // which address info is current use
            $address->address1 = $contact->address_1;
            $address->address2 = $contact->address_2;
            $address->phone = $contact->phone_1;
            $address->phone_mobile = $contact->phone_2;
            $address->postcode = $contact->postal_code;
            $address->city = $contact->city;
            $address->state = $contact->state;
            $address->country_code = $contact->country;
            $address->note = $contact->description;
            $address->registered_as = (string)$addressClass::REGISTERED_AS_TENANT_ADDRESS;
            if ($address->save()) {

                // after save new address information, save the address id in tenant profile
                // check if isNewAddress
                if($isNew) {
                    $tenantProfileClass = \Yii::$app->tenant->createModel('TenantProfile');
                    $tenantProfile = $tenantProfileClass::findOne(['store' => $model->app_store]);
                    $tenantProfile->address_registered_id = $address->id;
                    $tenantProfile->save();
                }

                // flash successfully
                // no need flash because redirect to difference view
                // Yii::$app->session->setFlash('message', ['success', 'Update Tenant Contact Information Successfully.']);
                return $this->redirect(['view', 'id' => $model->id]);

            } else {
                throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));
            }

        } elseif (!empty($address)) {
            // load current address
            $contact->first_name = $address->first_name;
            $contact->last_name = $address->last_name;
            $contact->email = $address->email;
            $contact->company_name = $address->company;
            $contact->address_1 = $address->address1;
            $contact->address_2 = $address->address2;
            $contact->city = $address->city;
            $contact->state = $address->state;
            $contact->country = $address->country_code;
            $contact->postal_code = $address->postcode;
            $contact->phone_1 = $address->phone;
            $contact->phone_2 = $address->phone_mobile;
            $contact->description = $address->note;
        }

        return $this->render('tabs', [
            'mode' => 'contact',
            'model' => $model,
            'contact' => $contact
        ]);
    }

    /**
     * list all modules of tenant
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionModules($id)
    {

        $tenant = $this->findModel($id);
        $modules = Yii::$app->tenant->createModel('TenantModuleSearch')->search(Yii::$app->request->queryParams);
        return $this->render('tabs', [
            'mode' => 'modules',
            'model' => $tenant,
            'modules' => $modules
        ]);
    }

    /**
     * CRUD tenant module belongs to tenant id and module id
     * if module id is empty, it means add new module to tenant
     * else update current relationship information between module and tenant
     *
     * @param $tid
     * @param $mid
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionModuleForm($tid, $mid)
    {
        $tenant = $this->findModel($tid);
        $modelClass = Yii::$app->tenant->createModel('TenantModule');
        $model = !empty($mid) ? $modelClass::findOne(['id' => $mid]) : $modelClass;
        $title = !empty($mid) ? Yii::t('base', 'Update Module') . ' #' . $model->id : Yii::t('base', 'Add new module');

        if (!Yii::$app->request->isPjax && Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()){

            // set base values
            $model->updated_by = Yii::$app->user->id;
            $model->updated_mode = $modelClass::UPDATE_MODE_MANUAL;
            $model->store = $tenant->app_store;
            $model->status = TenantModule::STATUS_ACTIVE;

            if($model->save())
                Yii::$app->session->setFlash('message', ['success', 'Update Tenant Module Successfully.']);
            else
                Yii::$app->session->setFlash('error', ['success', 'Error when update Tenant Module.']);
        }

        return $this->renderAjax('module_form', [
            'model' => $model,
            'title' => Yii::t('base', 'Tenant') . ": " . $tenant->name . ' \ ' . $title,
            'action' => ['module-form', 'tid' => $tenant->id, 'mid' => $mid]
        ]);
    }

    /**
     * get module information by module id from ajax request
     *
     * @param $id
     * @return string
     */
    public function actionSuggestModule($id)
    {
        if(Yii::$app->request->isAjax) {

            $tenantModuleClass = Yii::$app->tenant->createModel("TenantModule");
            $moduleInfo = $tenantModuleClass::getModuleExtraInfo($id);

            return json_encode(['module' => $moduleInfo[0], 'plans' => $moduleInfo[1]]);
        }
    }

}
