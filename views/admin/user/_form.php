<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
                'enableAjaxValidation' => true,
                'options' => [
                    'validateOnSubmit' => true,
                    // 'class' => 'base-form',
                ]
            ]);
        ?>
            <div class="info-item">
                <div class="info-item-header with-form-control form-header">
                    <h1><?= \Yii::t('base', 'User'); ?> / <?= \Yii::t('base', 'Add new User'); ?></h1>

                    <div class="buttons">
                        <?= \yii\helpers\Html::a(Yii::t('base', 'CANCEL'), Url::toRoute(['admin/auth/', 'type' => 'user']), ['class' => 'btn btn-default']) ?>
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
                                <?= $form->field($model, 'zone', ['template' => '{input}'])->radioList(User::getUserZones(), ['class' => 'zone-radio', 'separator' => '<br>']); ?>
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
                                <?= $form->field($model, 'timezone')->dropDownList([], ['class' => 'form-control']); ?>
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

                 <?= $form->field($model, 'store', ['template' => '{input}'])->hiddenInput() ?>

                <div class="row section" style="padding:20px 0;">
                    <div class="buttons">
                        <?= \yii\helpers\Html::submitButton(Yii::t('base', 'SAVE'), ['class' => 'pull-right btn btn-success']) ?>
                        <?= \yii\helpers\Html::a(Yii::t('base', 'CANCEL'), ['index'], ['class' => 'pull-right btn btn-default']) ?>
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
            format: 'DD-MM-YYYY'
        });

        $('.field-userform-staff_zone').parent().parent().hide();
        $('.field-userform-guest_zone').parent().parent().hide();
        $('#userform-staff_zone').attr('disabled', true);
        $('#userform-guest_zone').attr('disabled', true);
        if ($('input[name=" . '"UserForm[zone]"' . "]:checked').length > 0) {
            var zone = $('input[name=" . '"UserForm[zone]"' . "]:checked').val().split('_');
            for (i = 0; i < zone.length; i++) {
                if (zone[i] == 'staff') {
                    $('#userform-staff_zone').removeAttr('disabled');
                    $('.field-userform-staff_zone').parent().parent().show();
                }

                if (zone[i] == 'guest') {
                    $('#userform-guest_zone').removeAttr('disabled');
                    $('.field-userform-guest_zone').parent().parent().show();
                }
            }
        }

        $('input[name=" . '"UserForm[zone]"' . "]').change(function(){
            $('.field-userform-staff_zone').parent().parent().hide();
            $('.field-userform-guest_zone').parent().parent().hide();
            $('#userform-staff_zone').attr('disabled', true);
            $('#userform-guest_zone').attr('disabled', true);
            var zone = $(this).val().split('_');
            for (i = 0; i < zone.length; i++) {
                if (zone[i] == 'staff') {
                    $('#userform-staff_zone').removeAttr('disabled');
                    $('.field-userform-staff_zone').parent().parent().show();
                }

                if (zone[i] == 'guest') {
                    $('#userform-guest_zone').removeAttr('disabled');
                    $('.field-userform-guest_zone').parent().parent().show();
                }
            }
        })

        $('#userform-timezone').timezones();
    ";
    $this->registerJs($script, View::POS_END);
?>