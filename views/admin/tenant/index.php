<?php

use yii\helpers\Html;

// init default values
$this->title = Yii::t('base', 'Tenants');
$this->params['breadcrumbs'] = [];
$this->params['buttons'] = [];
$this->params['html'] = '';

// define index value
$this->params['breadcrumbs'][] = ['label' => $this->title, 'icon' => 'fa fa-globe', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage'];
//$this->params['buttons'][] = ['label' => Yii::t('base', 'Add new Tenant'), 'url' => ['create'], 'options' => ['class' => 'btn btn-success']];
$this->params['html'] = $this->render('_search', ['model' => $searchModel]);
?>

<?= $this->render('../widgets/_sub_header.php', [
    'breadcrumbs' => $this->params['breadcrumbs'],
    'buttons' => $this->params['buttons'],
    'html' => $this->params['html']
]); ?>
<div class="row">
    <section class="main-ctn">
            <?= \gxc\yii2base\widgets\BaseGridView::widget([
                'dataProvider' => $dataProvider,
                'showHeader' => false,
                'options' => ['class' => 'table-responsive section-data full-data'],
                'tableOptions' => ['class' => 'table table-hover tbl-grid'],
                'columns' => [
                    [
                        'class'=>'yii\grid\DataColumn',
                        'options' => ['style' => 'width:120px;'],
                        'attribute' => 'logo',
                        'content' => function ($model){
                            return \gxc\yii2base\models\tenant\Tenant::renderLogo($model->logo);
                        }
                    ],
                    [
                        'class'=>'yii\grid\DataColumn',
                        'attribute' => 'status',
                        'content' => function ($model){
                            return \gxc\yii2base\models\tenant\Tenant::renderBasicInfo($model, $this);
                        }
                    ],
                    [
                        'class'=>'yii\grid\DataColumn',
                        'attribute' => 'name',
                        'content' => function ($model) {
                            return \gxc\yii2base\models\tenant\Tenant::renderContactInfo($model->id);
                        }
                    ],
                    [
                        'class' => 'gxc\yii2base\widgets\BaseActionColumn',
                        'template' => '<div class="btn-group pull-right">{view} {update} {delete}</div>',
                    ],
                ],
            ]); ?>
    </section>
</div>
</section>