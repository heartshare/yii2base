<?php
use \yii\widgets\ActiveForm;

?>
<div class="tab-ctn info-wrapper">
    <?= $this->render('../widgets/_notification.php') ?>
    <div class="content-zone">
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'base-form',
            ]
        ]);
        ?>
            <div class="info-item">
                <div class="info-item-header with-form-control form-header">
                    <h1><?= Yii::t('base', 'General / Contact Information') ?></h1>

                    <div class="buttons">
                        <?= \yii\helpers\Html::submitButton(Yii::t('base', 'Save'), ['class' => 'pull-right btn btn-success']); ?>
                        <?= \yii\helpers\Html::a(Yii::t('base', 'Cancel'), ['view', 'id' => $tenant->id], ['class' => 'pull-right btn btn-default']) ?>
                    </div>
                </div>

                <div class="row section section-first">
                    <div class="col-md-3 section-summary">
                        <h1><?= Yii::t('base', 'Overview') ?></h1>

                        <p><?= Yii::t('base', 'All fields are required.') ?></p>
                    </div>
                    <div class="col-md-9 section-content">
                        <div class="inner-form row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'first_name')->textInput(['maxlength' => 128]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => 128]) ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => 128]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row section">
                    <div class="col-md-3 section-summary">
                        <h1><?= Yii::t('base', 'Contact Address') ?></h1>

                        <p><?= Yii::t('base', 'All contact address information.') ?></p>
                    </div>
                    <div class="col-md-9 section-content">
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'company_name')->textInput(['maxlength' => 128]) ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'address_1')->textInput() ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'address_2')->textInput() ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'city')->textInput() ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'state')->textInput(); ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'postal_code')->textInput() ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'country')->dropDownList(
                                    \gxc\yii2base\helpers\LocalizationHelper::getCountries(true), ['prompt' => Yii::t('base', '-- Select -- ')]); ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'phone_1')->textInput(['maxlength' => 128]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'phone_2')->textInput(['maxlength' => 128]) ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'description')->textarea();?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row section" style="padding:20px 0;">
                    <div class="buttons">
                        <?= \yii\helpers\Html::submitButton(Yii::t('base', 'Save'), ['class' => 'pull-right btn btn-success']); ?>
                        <?= \yii\helpers\Html::a(Yii::t('base', 'Cancel'), ['view', 'id' => $tenant->id], ['class' => 'pull-right btn btn-default']) ?>
                    </div>
                </div>

            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>