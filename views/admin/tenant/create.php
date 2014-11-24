<?php

use yii\helpers\Html;

$this->title = Yii::t('base', 'Add new {modelClass}', [
    'modelClass' => 'Tenant',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Tenants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('../widgets/_sub_header.php'); ?>

<div class="tenant-create">    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>