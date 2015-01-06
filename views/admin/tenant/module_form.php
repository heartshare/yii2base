<?php
use yii\widgets\ActiveForm;
use \yii\helpers\Html;

?>
<div class="modal-header">
    <h4 class="modal-title"> <?= $title ?>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </h4>
</div>
<div class="modal-body">

    <?php \yii\widgets\Pjax::begin([
        'enablePushState' => false,
        'id' => 'form-on-popup'
    ]); ?>
    <?= $this->render('../widgets/_notification.php', ['options' => ['style' => 'margin:0 0 10px 0']]) ?>
    <?php $form = ActiveForm::begin([
        'id' => 'module-form-main',
        'action' => $action,
        'options' => ['class' => 'base-form', 'style' => 'padding:0;',
            'data-pjax' => true // important to use pjax submit form
        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'module')->dropDownList(\gxc\yii2base\helpers\ModuleHelper::getAvailableModules(true), [
        'prompt' => Yii::t('base', '-- Select -- '),
        'onChange' => '
                    $.post("' . \yii\helpers\Url::toRoute(['suggest-module']) . '?id="+this.value+"", {_csrf: "' . Yii::$app->request->getCsrfToken() . '"}).done(function(data){
                        var obj = JSON.parse(data);
                        $("#module-info").html(obj.module);
                        $("#' . Html::getInputId($model, 'plan') . '").html(obj.plans);
                    });
                '
    ]); ?>
    <div class="form-group module-info" id="module-info">
        <?= empty($model->module) ? '' : $model->getModuleExtraInfo($model->module)[0]; ?>
    </div>
    <?= $form->field($model, 'plan')->dropDownList(\gxc\yii2base\helpers\ModuleHelper::getPlans($model->module, true), ['prompt' => Yii::t('base', '-- Select -- ')]); ?>
    <?= $form->field($model, 'expiry_mode')->dropDownList($model->getExpiredModes(), ['prompt' => Yii::t('base', '-- Select -- ')]); ?>
    <?= $form->field($model, 'expired_at')->textInput() ?>
    <div class="buttons text-right">
        <?= Html::a(Yii::t('base', 'Cancel'), '#', ['data-dismiss' => 'modal', 'class' => 'btn btn-default']); ?>
        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-success', 'data-pax' => true]) ?>
    </div>
    <?php ActiveForm::end() ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
