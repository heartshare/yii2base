<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\controllers\admin;

use gxc\yii2base\models\tenant\Tenant;
use gxc\yii2base\models\tenant\TenantForm;
use gxc\yii2base\models\tenant\TenantProfile;
use Yii;
use yii\base\Model;
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
            ],
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
         $model = \Yii::$app->tenant->createModel('Tenant');

        if($model->load(Yii::$app->request->post()) && $model->save()){

            // check if not having user register information
            // create user register info by current user
            $tenantProfile = TenantProfile::findOne(['store' => $model->app_store]);
            if(empty($tenantProfile)){
                $tenantProfile = new TenantProfile();
                $tenantProfile->store = $model->app_store;
                $tenantProfile->user_registered_id = 4;
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // check if not having user register information
            // create user register info by current user
            $tenantProfile = TenantProfile::findOne(['store' => $model->app_store]);
            if(empty($tenantProfile)){
                $tenantProfile = new TenantProfile();
                $tenantProfile->store = $model->app_store;
                $tenantProfile->user_registered_id = 4;
                $tenantProfile->registered_at = \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
                $tenantProfile->save();
            }

            // flash successfully
            Yii::$app->session->setFlash('message', ['success', 'Update Tenant Successfully.']);
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
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
        return $this->render('view', [
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
}
