<?php

use yii\helpers\Html;

$this->title = Yii::t('base', 'Update {modelClass}: ', [
    'modelClass' => 'Tenant',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Tenants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
?>
<div class="tenant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
