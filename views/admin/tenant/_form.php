<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use gxc\yii2widgets\switcher\Switcher;

?>

<div class="tenant-form">
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
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>
                </div>
            </div>
            <div class="inner-form row">
                <div class="col-md-8">
                    <?= $form->field($model, 'system_domain')->textInput(['maxlength' => 128]) ?>
                </div>
            </div>
            <div class="inner-form row">
                <div class="col-md-8">
                    <?= $form->field($model, 'domain')->textInput(['maxlength' => 128]) ?>
                </div>
            </div>            
            <div class="inner-form row">
                <div class="col-md-3">
                    <?= $form->field($model, 'logo')->textInput(['maxlength' => 128]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'status')->dropDownList($model->tenantStatuses()); ?>
                </div>
            </div>                                
        </div>
    </div>
    <div class="row section">
        <div class="col-md-3 section-summary">
            <h1><?= \Yii::t('base', 'Tenant Stores'); ?></h1>
            <p><?= \Yii::t('base', 'Store in Tenant is used to seperate or merge data between tenants.'); ?></p>
        </div>
        <div class="col-md-9 section-content">
            <div class="inner-form row">
                <div class="col-md-8">
                    <?= $form->field($model, 'app_store')->textInput(['maxlength' => 64]) ?>
                </div>
            </div>
            <div class="inner-form row">
                <div class="col-md-8">
                    <?= $form->field($model, 'content_store')->textInput(['maxlength' => 64]) ?>
                </div>
            </div>
            <div class="inner-form row">
                <div class="col-md-8">
                    <?= $form->field($model, 'resource_store')->textInput(['maxlength' => 64]) ?>
                </div>
            </div>                    
        </div>
    </div>    
    <div class="row section buttons">
        <?= Html::submitButton(Yii::t('base', ' CREATE '), ['class' => 'btn btn-primary']) ?>
    </div>    

    <?php ActiveForm::end(); ?>
</div>
