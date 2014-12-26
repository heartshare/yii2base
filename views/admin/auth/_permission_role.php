<?php

use yii\helpers\Url;
?>

<?php if (!empty($modules) && !empty($rolePermissions)): ?>
<div class="info-item-header with-form-control grid-header">
    <h1>Permissions Assignment / <?= $roleName ?> <label class="label label-success">System Role</label></h1>
    <div class="btn-group btn-permissions">
        <?php foreach ($modules as $k => $module): ?>
            <?php
                if ((isset($_GET['module']) && $_GET['module'] == $module->module) || (!isset($_GET['module']) && $k == 0)) {
                    $btnClass = 'btn-warning';
                } else {
                    $btnClass = 'btn-default';
                }

                $url = Url::toRoute(['/base/admin/auth/assign', 'id' => $_GET['id'], 'module' => $module->module, 'tenant' => $tenantId]);
            ?>
            <a class="pull-left btn <?= $btnClass ?>" href="<?= $url ?>">
                <?= ucfirst($module->module) ?> Module
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="row section section-first section-data" style="color:#333!important;">
    <div class="table-responsive col-md-7" style="margin-top: 10px;">

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
                        <td width="80%"><?= ucfirst($detail['controller']) ?> | <?= $detail['description'] ?><span class="hidden-xs"> | <?= $item ?></span></td>
                        <td width="15%">
                            <input type="checkbox" name="my-checkbox" class="switch" data-size="mini" <?php if (isset($detail['check']) && $detail['check'] == 1): ?>checked<?php endif; ?>>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>