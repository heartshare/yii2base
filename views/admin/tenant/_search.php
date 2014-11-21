<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="tenant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'app_store') ?>

    <?= $form->field($model, 'content_store') ?>

    <?= $form->field($model, 'resource_store') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'domain') ?>

    <?php // echo $form->field($model, 'system_domain') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('base', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
