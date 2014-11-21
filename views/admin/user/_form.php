<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
    		'options' => ['class' => 'generalForm']
    	]); 
    ?>

    <div class="row section section-no-border">
      	<div class="col-md-3 section-summary">
        	<h1><?= \Yii::t('base', 'Overview'); ?></h1>
        	<p><?= \Yii::t('base', 'All fields are required.'); ?></p>
      	</div>
      	<div class="col-md-9 section-content">
      		<div class="inner-form row">
      			<div class="col-md-8">
      				<?= $form->field($model, 'store')->textInput(['maxlength' => 64]) ?>
      			</div>
      		</div>
      		<div class="inner-form row">
      			<div class="col-md-8">
      				<?= $form->field($model, 'email')->textInput(['maxlength' => 128]) ?>
      			</div>
      		</div>
      		
    		
      	</div>
    </div>    
    <div class="row section buttons">
      	<?= Html::submitButton(Yii::t('base', ' CREATE '), ['class' => 'btn btn-primary']) ?>
    </div>    

    <?php ActiveForm::end(); ?>

</div>
