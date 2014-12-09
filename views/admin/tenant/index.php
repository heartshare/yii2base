<?php

use yii\helpers\Html;

$this->title = Yii::t('base', 'Tenants');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'icon' => 'fa fa-globe'];
$this->params['buttons'][] = ['label' => Yii::t('base', 'Add new Tenant'), 'url' => ['create'], 'options' => ['class' => 'btn btn-success']];
?>

<?= $this->render('../widgets/_sub_header.php', ['breadcrumbs' => $this->params['breadcrumbs'], 'buttons' => $this->params['buttons']]); ?>
<section class="main-ctn col-md-12">
<div class="inner">
    <div class="col-md-12">
        <section class="row search-region">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
        </section>
        <section class="row">
        <?= \gxc\yii2base\widgets\BaseGridView::widget([
            'dataProvider' => $dataProvider,
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
                    'attribute' => 'name',
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
                    'class' => 'gxc\yii2base\widgets\BaseActionColumn',
                    'template' => '<div class="btn-group pull-right">{update} {delete}</div>',
                ],
            ],
        ]); ?>
        </section>
    </div>
</div>
</section>