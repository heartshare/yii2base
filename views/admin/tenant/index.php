<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('base', 'Tenants');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'icon' => 'fa fa-globe'];
$this->params['buttons'][] = ['label' => Yii::t('base', 'Add new Tenant'), 'url' => ['create'], 'options' => ['class' => 'btn btn-success']];
?>

<?= $this->render('../widgets/_sub_header.php', ['breadcrumbs' => $this->params['breadcrumbs'], 'buttons' => $this->params['buttons']]); ?>
<div class="container-fluid">
<div class="rows">
    <div class="col-md-12">
        <?= $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'class' => 'table table-responsive table-striped'
            ],
            'columns' => [
                [
                    'class'=>'yii\grid\DataColumn',
                    'attribute' => 'status',
                    'content' => function ($model){
                        return \gxc\yii2base\models\tenant\Tenant::renderTenantStatus($model->status);
                    }
                ],
                [
                    'class'=>'yii\grid\DataColumn',
                    'attribute' => 'status',
                    'content' => function ($model) {
                        return Html::a($model->name, ["update", 'id' => $model->id]);
                    }
                ],
                [
                    'class'=>'yii\grid\DataColumn',
                    'attribute' => 'domain',
                    'content' => function ($model) {
                        return Html::a($model->domain, $model->domain, ['target' => '_blank']);
                    }
                ],
                'app_store',
                'content_store',
                'resource_store',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>

    </div>
</div>
</div>