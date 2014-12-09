<?php

$this->title = Yii::t('base', 'Add new {modelClass}', [
    'modelClass' => 'Tenant',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Tenants'), 'url' => ['index'], 'icon' => 'fa fa-globe'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'][] = ['label' => Yii::t('base', 'Cancel'), 'options' => ['class' => 'btn btn-default']];
$this->params['buttons'][] = ['label' => Yii::t('base', 'Save'), 'options' => ['class' => 'btn btn-primary', 'onclick' => "$('#w0').submit();"]];

?>

<?= $this->render('../widgets/_sub_header.php', ['breadcrumbs' => $this->params['breadcrumbs'], 'buttons' => $this->params['buttons']]); ?>
<?= $this->render('../widgets/_notification.php') ?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>