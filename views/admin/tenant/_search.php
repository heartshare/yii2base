<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<!--<div class="search-area highlight" style="background-color: #f7f7f9; padding: 10px 10px 0 10px; margin-top: 10px; border-radius: 4px;">-->
<div class="well well-sm" style="margin-top: 10px; margin-bottom: 5px;">
    <div class="row">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>
        <div class="col-md-4">
            <?= $form->field($model, 'keywords') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'field')->dropDownList($model->getTenantSearchFields(), ['class' => 'form-control']); ?>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
            <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-primary form-control']) ?>
            </div>
        </div>

        <div class="col-md-12">
            <label>Quick filter: </label>
            <ul class="quick-filter">
                <li><a href="">All</a></li>
                <li><a href="">Active</a></li>
                <li><a href="">Inactive</a></li>
            </ul>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>