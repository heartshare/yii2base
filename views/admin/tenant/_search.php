<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'id' => 'tenant-search-form',
    'action' => ['index'],
    'method' => 'get',
    'options' => ['class' => 'form-inline']
]); ?>
<div class="form-group">
    <?= Html::activeInput('text', $model, 'keywords', ['class' => 'form-control input-sm', 'placeholder' => Yii::t('base', 'Search Keywords in ...')]) ?>
</div>
<div class="form-group">
    <?= Html::activeDropDownList($model, 'field', $model->getTenantSearchFields(), ['class' => 'form-control input-sm']) ?>
</div>
<div class="form-group">
    <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-sm btn-warning']) ?>
    <?= Html::a(Yii::t('base', 'Add new Tenant'), ['create'], ['class' => 'btn btn-sm btn-success'])?>
</div>
<?php ActiveForm::end(); ?>
