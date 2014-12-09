<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="col-md-12">
    <?php $form = ActiveForm::begin([
        'id' => 'tenant-search-form',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline']
    ]); ?>
        <div class="form-group">
            <?= Html::activeInput('text', $model, 'keywords', ['class' => 'form-control input-sm', 'placeholder' => Yii::t('base', 'Search Keywords in ...')]) ?>
            <?= Html::activeDropDownList($model, 'field', $model->getTenantSearchFields(), ['class' => 'form-control input-sm']) ?>
            <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-sm btn-warning']) ?>
        </div>
        <div class="form-group" style="display: block;">
            <ul class="list-filter list-inline">
                <li><a href="javascript:;" onclick="tenantQuickFilter('all');">All</a></li>
                <li><a href="javascript:;" onclick="tenantQuickFilter('active');">Active</a></li>
                <li><a href="javascript:;" onclick="tenantQuickFilter('inactive');">Inactive</a></li>
            </ul>
            <?= Html::activeHiddenInput($model, 'status'); ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
<script>
    function tenantQuickFilter(status){
        $target_status_input = $("#<?= Html::getInputId($model, 'status'); ?>");
        $target_status_input.val(status);
        $("#tenant-search-form").submit();
    };
</script>