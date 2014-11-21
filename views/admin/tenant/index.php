<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('base', 'Tenants');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('base', 'Create {modelClass}', [
    'modelClass' => 'Tenant',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'app_store',
            'content_store',
            'resource_store',
            'name',
            // 'domain',
            // 'system_domain',
            // 'logo',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
