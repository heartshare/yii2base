<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\controllers\admin;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

use gxc\yii2base\classes\BeController;

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

        // ajax validation
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

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
                // flash error
                Yii::$app->session->setFlash('message', ['error', Yii::t('base', 'Error when save new Tenant.')]);
                return $this->render('create', [
                    'model' => $model,
                ]);
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

        // ajax validation
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

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
                // flash error
                Yii::$app->session->setFlash('message', ['error', Yii::t('base', 'Error when update Tenant.') . ' #' . $tenant->id]);
                return $this->render('update', [
                    'model' => $model,
                ]);
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
        $userClass = \Yii::$app->tenant->getModel('User', 'class');
        // get user store settings
        $userStore = \Yii::$app->tenant->getModel((new \ReflectionClass($userClass))->getShortName(), 'store');
        // find user
        $user = $userClass::findOne(['email' => $model->email, 'store' => $model->$userStore]);
        if (empty($user)) {
            $user = \Yii::$app->tenant->createModel((new \ReflectionClass($userClass))->getShortName());
            $user->email = $model->email;
            $user->store = $tenant->$userStore;
            if($user->save()){
                // create user display
                $userDisplay = \Yii::$app->tenant->createModel('UserDisplay');
                // get user display store settings
                $userDisplayStore = \Yii::$app->tenant->getModel((new \ReflectionClass($userDisplay))->getShortName(), 'store');
                // save user display information
                $userDisplay->store = $model->$userDisplayStore;
                $userDisplay->user_id = $user->id;
                $userDisplay->display_name = $userDisplay->screen_name = Yii::t('base', 'Unknown');
                $userDisplay->save();
            }
        }

        // create tenant profile if not exist
        $tenantProfileClass = \Yii::$app->tenant->getModel('TenantProfile', 'class');
        // get tenant profile store settings
        $tenantProfileStore = \Yii::$app->tenant->getModel((new \ReflectionClass($tenantProfileClass))->getShortName(), 'store');
        // find tenant profile
        $tenantProfile = $tenantProfileClass::findOne(['store' => $model->$tenantProfileStore]);
        if (empty($tenantProfile) && !empty($user->id)) {
            $tenantProfile = Yii::$app->tenant->createModel('TenantProfile');
            $tenantProfile->store = $tenant->$tenantProfileStore;
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
        $tenantClass = \Yii::$app->tenant->getModel('Tenant', 'class');

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
        $addressClass = Yii::$app->tenant->getModel('Address', 'class');
        // get address store settings
        $addressStore = \Yii::$app->tenant->getModel((new \ReflectionClass($addressClass))->getShortName(), 'store');
        // find address
        $address = $addressClass::findOne(['id' => $model->profile->address_registered_id]);

        if ($contact->load(Yii::$app->request->post()) && $contact->validate()) {

            $isNew = false;
            if (empty($address)) {
                $address = Yii::$app->tenant->createModel((new \ReflectionClass($addressClass))->getShortName());
                $isNew = true;
            }
            $address->store = $model->$addressStore;
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
                    // get tenant profile store settings
                    $tenantProfileStore = \Yii::$app->tenant->getModel((new \ReflectionClass($tenantProfileClass))->getShortName(), 'store');
                    // find tenant profile store
                    $tenantProfile = $tenantProfileClass::findOne(['store' => $model->$tenantProfileStore]);
                    $tenantProfile->address_registered_id = $address->id;
                    $tenantProfile->save();
                }
                // flash successfully
                // no need flash because redirect to difference view
                // Yii::$app->session->setFlash('message', ['success', 'Update Tenant Contact Information Successfully.']);
                return $this->redirect(['view', 'id' => $model->id]);

            } else {
                Yii::$app->session->setFlash('message', ['error', 'Error when update Tenant Contact Information.']);
                return $this->render('tabs', [
                    'mode' => 'contact',
                    'model' => $model,
                    'contact' => $contact
                ]);
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
        $modelClass = Yii::$app->tenant->getModel('TenantModule', 'class');
        // get tenant module store settings
        $tenantModuleStore = \Yii::$app->tenant->getModel((new \ReflectionClass($modelClass))->getShortName(), 'store');

        $model = !empty($mid) ? $modelClass::findOne(['id' => $mid]) : Yii::$app->tenant->createModel((new \ReflectionClass($modelClass))->getShortName());
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
            $model->store = $tenant->$tenantModuleStore;
            $model->status = $modelClass::STATUS_ACTIVE;

            if ($model->save()) {
                Yii::$app->session->setFlash('message', ['success', 'Update Tenant Module Successfully.']);
                Yii::$app->session->setFlash('modal', ['close' => true, 'waitingTime' => 5]);
            } else
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
            Yii::$app->response->format = Response::FORMAT_JSON;

            $tenantModuleClass = Yii::$app->tenant->getModel("TenantModule", 'class');
            $moduleInfo = $tenantModuleClass::getModuleExtraInfo($id);

            return [
                'module' => $moduleInfo[0],
                'plans' => $moduleInfo[1]
            ];
        }
    }

}
