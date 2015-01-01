<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

use gxc\yii2base\models\user\User;
use gxc\yii2base\assets\app\LayoutAsset;
$layoutAsset = LayoutAsset::register($this);
?>

<div class="tab-ctn info-wrapper">
    <div class="content-zone">
        <?= $this->render('../widgets/_notification.php') ?>
        <?php $form = ActiveForm::begin([
                'id' => $formId,
                'enableAjaxValidation'=>true,
                'options' => [
                'validateOnSubmit'=>true,
                    // 'class' => 'base-form',
                ]
            ]);
        ?>
            <div class="info-item">
                <div class="info-item-header with-form-control form-header">
                    <h1><?= \Yii::t('base', 'User'); ?> / <?= \Yii::t('base', 'Add new User'); ?></h1>

                    <div class="buttons">
                        <?= \yii\helpers\Html::a(Yii::t('base', 'CANCEL'), ['index'], ['class' => 'btn btn-default']) ?>
                        <?= \yii\helpers\Html::submitButton(Yii::t('base', 'SAVE'), ['class' => 'btn btn-success']) ?>                                             
                    </div>
                </div>

                <?= $form->errorSummary($model); ?>

                <div class="row section section-first">
                    <div class="col-md-3 section-summary">
                        <h1><?= \Yii::t('base', 'Overview'); ?></h1>
                        <p><?= \Yii::t('base', 'All fields are required.'); ?></p>
                    </div>
                    <div class="col-md-9 section-content">
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => 128]) ?>
                            </div>
                        </div>

                        <div class="inner-form row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'first_name')->textInput(['maxlength' => 128]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => 128]) ?>
                            </div>
                        </div>

                        <div class="inner-form row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'display_name')->textInput(['maxlength' => 128]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'screen_name')->textInput(['maxlength' => 128]) ?>
                            </div>
                        </div>

                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 128]) ?>
                            </div>
                        </div>

                        <div class="inner-form row">
                            <div class="col-md-8">
                                <label class="control-label"><?= \Yii::t('base', 'This is an account of'); ?></label>
                                <?= $form->field($model, 'zone', array('template' => '{input}'))->radioList(User::getUserZones(), ['class' => 'zone-radio', 'separator' => '<br>']); ?>
                            </div>
                        </div>

                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'staff_zone')->dropDownList($staffZoneRoles, ['class' => 'form-control']); ?>
                            </div>
                        </div>

                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'guest_zone')->dropDownList($guestZoneRoles, ['class' => 'form-control']); ?>
                            </div>
                        </div>

                        <div class="inner-form row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'status')->dropDownList(User::getUserStatuses(), ['class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row section">
                    <div class="col-md-3 section-summary">
                        <h1><?= \Yii::t('base', 'Profile'); ?></h1>
                    </div>
                    <div class="col-md-9 section-content">
                        <div class="inner-form row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'gender')->dropDownList(User::getUserGenders(), ['class' => 'form-control']); ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'location')->textInput(['maxlength' => 64]) ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'timezone')->textInput(['maxlength' => 64]) ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'birthdate')->textInput(['maxlength' => 64]) ?>
                            </div>
                        </div>
                        <div class="inner-form row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'bio')->textArea() ?>
                            </div>
                        </div>
                    </div>
                </div>

                 <?= $form->field($model, 'store')->hiddenInput() ?>

                <div class="row section" style="padding:20px 0;">
                    <div class="buttons">
                        <a class="pull-right btn btn-success"> SAVE </a>
                        <a class="pull-right btn btn-default "> CANCEL </a>
                       
                    </div>
                </div>

            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
    $script = "
        $('#userform-birthdate').datetimepicker({
            pickTime: false,
            format: 'DD/MM/YYYY'
        });
    ";
    $this->registerJs($script, View::POS_END);
?>