<?php

use yii\helpers\Html;

$this->title = Yii::t('base', 'Create {modelClass}', [
    'modelClass' => 'Tenant',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Tenants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="header-row">
<div class="header-row-wrapper">
  <header class="header-1">
    <h1 class="header-main" id="page-header" rel=""> 
		<i class="fa fa-users"></i> 
		<span class="breadcrumb"><a href="#">Tenant</a> \</span> Add New Tenant
	</h1>
    <div class="header-right pull-right"> 
		<a class="btn btn-default" href="#">Cancel</a> 
		<a class="btn btn-primary" href="javascript:void(0)" onclick="$('#myform').submit();"> CREATE </a> 
	</div>
  </header>
</div>
</div>

<div class="user-create">    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>