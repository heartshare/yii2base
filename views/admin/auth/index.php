<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Nav;

$this->title = Yii::t('base', 'Permissions - {modelName}', [
	'modelName' => $tenant->name
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Auth'), 'url' => ['index'], 'icon'=>'fa fa-lock'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'][] = ['label' => Yii::t('base', 'Add module for this Tenant'), 'url' => ['add-module'], 'options' => ['class' => 'btn btn-success']];
?>

<?= $this->render('../widgets/_sub_header.php', [
	'breadcrumbs' => $this->params['breadcrumbs'],	
	'buttons' => $this->params['buttons'],	
]); ?>

<div class="auth-index">    
	<section class="main-ctn col-md-12">		
		<div class="inner">


			
			<h3><?= \Yii::t('base', '{tenantName} Modules and Permissions', ['tenantName'=>$tenant->name]);?> </h3>

			<?php 				
				foreach ($modules as $m) {
					$moduleNav[] = [
 						'label' => ucfirst($m->module).' '.'Module', 	
 						'url' => [''],			
 						'active' => $currentModule->module == $m->module
 					];
				}
			?>

				
			<?php
				echo Nav::widget(['items'=>$moduleNav, 'options'=>['class'=>'nav nav-pills']]);
			?>

			<section class="row summary-region">
        		<table cellpadding="4">					
					<tbody>
						<tr>
							<td align="center"><i class="fa fa-info-circle"></i></td>
							<td>&nbsp;Plan: <?= $currentModule->plan;?></td>
						</tr>
						<tr>
							<td align="center"><i class="fa fa-unlock"></i></td>
							<td>&nbsp;Expired mode: IT</td>
						</tr>
						<tr>
							<td align="center"><i class="fa fa-clock-o"></i></td>
							<td>&nbsp;n/a</td>
						</tr>
					</tbody>
				</table>
        	</section>

        	<h5>Roles</h5>						
			
		</div>
	</section>    
</div>