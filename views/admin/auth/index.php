<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('base', 'Permissions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Auth'), 'url' => ['index'], 'icon'=>'fa fa-lock'];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('../widgets/_sub_header.php', [
	'breadcrumbs' => $this->params['breadcrumbs'],	
]); ?>

<div class="auth-index">    
    
</div>