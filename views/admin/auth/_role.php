<?php

use yii\helpers\Url;
?>

<div class="row section section-first section-data">
    <div class="table-responsive" style="margin-top: 10px;">
        <table class="table table-hover tbl-grid">
            <thead>
                <tr>
                    <th style="width:25%"><a href="">Role</a></th> 
                    <th><a href="">Management Rights</a></th>           
                    <th></th>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $role => $roleDetail): ?>
                <tr>
                    <td><a href="#"><strong><?= $roleDetail['description'] ?></strong></a></td>
                    <td><span class="statusDot statusDot-danger"></span></td>               
                    <td>
                        <div class="btn-group pull-right grid-action-buttons">
                            <a class="pull-left btn btn-xs btn-default" href="<?= Url::toRoute(['/base/admin/auth/assign', 'id' => $role, 'module' => isset($currentModule->module) ? $currentModule->module : 'app', 'tenant' => $tenantId]) ?>" title="Update" data-pjax="0"><span class="fa fa-tasks"></span>Permissions</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>