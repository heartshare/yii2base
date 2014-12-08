<?php
use yii\widgets\ActiveForm;

?>
<div class="tenant-form">
    <?php $form = ActiveForm::begin();
    ?>
    <div class="row section section-no-border">
        <div class="col-md-3 section-summary">
            <h1><?= \Yii::t('base', 'Overview'); ?></h1>
            <p><?= \Yii::t('base', 'All fields are required.'); ?></p>
        </div>
        <div class="col-md-9 section-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'domain')->textInput(['maxlength' => 128]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'system_domain')->textInput(['maxlength' => 128]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'status')->dropDownList($model->getTenantStatuses(), ['class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">&nbsp;</label>
                            <div class="img-rounded" style="height: 180px; width: 100%; max-width: 180px; background: #c0c0c0"></div>
                            <div style="text-align: center; width: 180px; padding: 5px;">
                                <a href="#">Add Logo</a> - <a href="#">Remove</a>
                            </div>
                        </div>
                    </div>
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
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'app_store')->dropDownList($model->getTenantStores('app', $model), ['class' => 'form-control', 'prompt' => Yii::t('base', '-- Select -- ')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'content_store')->dropDownList($model->getTenantStores('content'), ['class' => 'form-control', 'prompt' => Yii::t('base', '-- Select -- ')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'resource_store')->dropDownList($model->getTenantStores('resource'), ['class' => 'form-control', 'prompt' => Yii::t('base', '-- Select -- ')]); ?>
                </div>
            </div>                    
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
