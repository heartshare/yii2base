<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
?>

<div class="tab-ctn info-wrapper">
    <div class="content-zone">
        <div class="info-item">
            <div class="info-item-header with-form-control grid-header">
                <h1>Assignment / <?= $userName ?> <label class="label label-success"><?= isset($_GET['type']) ? ucfirst($_GET['type']) : '' ?></label></h1>
                <div class="btn-group btn-permissions">
                    <?php foreach ($modules as $k => $module): ?>
                        <?php
                            if ((isset($_GET['module']) && $_GET['module'] == $module->module) || (!isset($_GET['module']) && $k == 0)) {
                                $btnClass = 'btn-warning';
                            } else {
                                $btnClass = 'btn-default';
                            }
                        ?>
                        <a class="pull-left btn <?= $btnClass ?>" href="<?= Url::toRoute(['assign', 'type' => isset($_GET['type']) ? $_GET['type'] : 'role', 'id' => $_GET['id'], 'module' => $module->module, 'tenant' => $tenantId]) ?>">
                            <?= ucfirst($module->module) ?> Module
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>       

            <?php if (!empty($modules) && !empty($rolePermissions)): ?>
            <div class="row section section-first section-data" style="color:#333!important;">

                <?= $this->render('../widgets/_notification.php') ?>

                <?php 
                    $form = ActiveForm::begin([
                        'id' => 'permission-form',
                        'options' => [
                            'class' => 'base-form permission-form',
                            'style' => 'padding:0px;'
                        ]
                    ]);
                ?>
                    <div class="table-responsive col-md-7" style="margin-top: 10px;">
                        <div>This user has permission from roles: </div>
                        <?php foreach ($rolePermissions as $region => $itemRegion): ?>
                        <table class="table table-hover table-5">
                            <thead>
                                <tr>
                                    <th style="width:60%;color:#333"><strong><?= ucfirst($region) ?></strong></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($itemRegion as $item => $detail): ?>
                                    <tr>
                                        <td width="80%"><?= $detail['controller'] ?> | <?= $detail['description'] ?><span class="hidden-xs"> | <?= $item ?></span></td>
                                        <td width="15%">
                                            <input type="checkbox" name="permissionStatus[<?= $region ?>][<?= $item ?>]" class="switch" data-size="mini" <?php if (isset($detail['check']) && $detail['check'] == 1): ?>checked<?php endif; ?>>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endforeach; ?>
                    </div>

                    <div class="row section buttons" style="padding:10px 0;">
                        <?= Html::submitButton(Yii::t('base', ' SAVE '), ['class' => 'btn btn-success']) ?>
                    </div>    
                <?php ActiveForm::end(); ?>
            </div>
            <?php else: ?>
                <h4><?= \Yii::t('base', 'No permissions found') ?></h4>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    // Set state for all children actions if root action is checked
    $script = '
        $(".permission-status").on("switchChange.bootstrapSwitch", function(e, state) {
            var itemId = $(this).attr("id");
            var controller = $(this).attr("data-group");
            if (itemId.indexOf("all") != -1) {
                $("input[data-group=\'" + controller + "\']").each(function(e) {
                    if ($(this).attr("id").indexOf("all") == -1) {
                        $(this).bootstrapSwitch("state", state, state);
                    }
                });
            }
        });';
    // $this->registerJs($script, View::POS_END);
?>