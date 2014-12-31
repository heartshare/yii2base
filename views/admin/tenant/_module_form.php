<?php
use yii\widgets\ActiveForm;
use \yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([
        'options' => ['class' => 'base-form', 'style' => 'padding:0;']
    ]); ?>
    <?= $form->field($model, 'module')->dropDownList(\gxc\yii2base\helpers\ModuleHelper::getAvailableModules(true), [
            'prompt' => Yii::t('base', '-- Select -- '),
            'onChange' => '

            ';
        ]); ?>
    <div class="form-group" id="module-info">

    </div>
    <?= $form->field($model, 'plan')->dropDownList(\gxc\yii2base\helpers\ModuleHelper::getPlans(null), ['prompt' => Yii::t('base', '-- Select -- ')]); ?>
    <?= $form->field($model, 'expiry_mode')->dropDownList($model->getExpiredModes(), ['prompt' => Yii::t('base', '-- Select -- ')]); ?>
    <?= $form->field($model, 'expired_at')->textInput() ?>
    <div class="buttons text-right">
        <?= Html::a(Yii::t('base', 'Cancel'), '#', ['data-dismiss' => 'modal', 'class' => 'btn btn-default']); ?>
        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end() ?>
