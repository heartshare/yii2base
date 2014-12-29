<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\controllers\admin;

use gxc\yii2base\models\address\Address;
use gxc\yii2base\models\tenant\Tenant;
use gxc\yii2base\models\tenant\TenantForm;
use gxc\yii2base\models\tenant\TenantContact;
use gxc\yii2base\models\tenant\TenantProfile;
use gxc\yii2base\models\user\User;
use Yii;
use yii\base\Model;
use yii\behaviors\AttributeBehavior;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use gxc\yii2base\classes\BeController;

/**
 * Tenant Controller of Base Module
 *
 * This is the base Tenant controller
 *
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // check if not having user register information
            // create user register info by current user
            $tenantProfile = TenantProfile::findOne(['store' => $model->app_store]);
            if (empty($tenantProfile)) {
                $tenantProfile = new TenantProfile();
                $tenantProfile->store = $model->app_store;
                $tenantProfile->user_registered_id = User::findOne(['email' => $model->email])->id;
                $tenantProfile->registered_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
                $tenantProfile->save();
            }

            // flash successfully
            Yii::$app->session->setFlash('message', ['success', 'Create New Tenant Successfully.']);
            return $this->redirect(['view', 'id' => $model->id]);
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
            $tenant->save();

            // check if not having user register information
            // create user register info by current user
            $tenantProfile = TenantProfile::findOne(['store' => $model->app_store]);
            if (!empty($tenantProfile)) {
                $tenantProfile->user_registered_id = User::findOne(['email' => $model->email])->id;
                $tenantProfile->save();
            }

            // flash successfully
            Yii::$app->session->setFlash('message', ['success', 'Update Tenant Successfully.']);
            return $this->redirect(['update', 'id' => $tenant->id]);
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
            throw new NotFoundHttpException('The requested page does not exist.');
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

        $contact = new TenantContact();

        // create new address or load from db if exist
        if($model->profile->address_registered_id !== 0)
            $address = Address::findOne(['id' => $model->profile->address_registered_id]);
        else
            $address = new Address();

        if ($contact->load(Yii::$app->request->post()) && $contact->validate()) {

            $address->store = $model->app_store;
            $address->first_name = $contact->first_name;
            $address->last_name = $contact->last_name;
            $address->email = $contact->email;
            $address->company = $contact->company_name;
            $address->alias = (string)Address::ALIAS_ADDRESS_1; // which address info is current use
            $address->address1 = $contact->address_1;
            $address->address2 = $contact->address_2;
            $address->phone = $contact->phone_1;
            $address->phone_mobile = $contact->phone_2;
            $address->postcode = $contact->postal_code;
            $address->city_code = $contact->city;
            $address->state_code = $contact->state;
            $address->country_code = $contact->country;
            $address->note = $contact->description;
            $address->registered_as = (string)Address::REGISTERED_AS_TENANT_ADDRESS;
            if($address->save()){
                $tenantProfile = TenantProfile::findOne(['store' => $model->app_store]);
                $tenantProfile->address_registered_id = $address->id;
                $tenantProfile->save();

                // flash successfully
                // Yii::$app->session->setFlash('message', ['success', 'Update Tenant Contact Information Successfully.']);
                return $this->redirect(['view', 'id' => $model->id]);

            } else {
                // flash error
                Yii::$app->session->setFlash('message', ['error', 'Error when update Tenant Contact Information.']);
                return $this->redirect(['contact-update', 'id' => $model->id]);
            }

        } else {
            if(!empty($address)) {
                // load current address
                $contact->first_name = $address->first_name;
                $contact->last_name = $address->last_name;
                $contact->email = $address->email;
                $contact->company_name = $address->company;
                $contact->address_1 = $address->address1;
                $contact->address_2 = $address->address2;
                $contact->city = $address->city_code;
                $contact->state = $address->state_code;
                $contact->country = $address->country_code;
                $contact->postal_code = $address->postcode;
                $contact->phone_1 = $address->phone;
                $contact->phone_2 = $address->phone_mobile;
                $contact->description = $address->note;
            }
        }

        return $this->render('tabs', [
            'mode' => 'contact',
            'model' => $model,
            'contact' => $contact
        ]);
    }
}
