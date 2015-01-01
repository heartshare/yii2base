<?php

use yii\helpers\Url;
?>
<div class="tab-ctn info-wrapper">
    <div class="content-zone">
        <div class="info-item">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item-header with-form-control grid-header">
                        <h1><?= \Yii::t('base', 'Permissions'); ?> / <?= \Yii::t('base', 'Roles'); ?></h1>
                    </div>
                    <div class="row section section-first section-data">
                        <div class="table-responsive" style="margin-top: 10px;">
                            <table class="table table-hover tbl-grid">
                                <thead>
                                    <tr>
                                        <th style="width:25%"><a href=""><?= Yii::t('base','Role'); ?></a></th> 
                                        <th><a href=""><?= Yii::t('base','Management Rights'); ?></a></th>           
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
                                                <a class="pull-left btn btn-xs btn-default" href="<?= Url::toRoute(['assign', 'type' => 'role', 'id' => $role, 'module' => isset($currentModule->module) ? $currentModule->module : 'app', 'tenant' => $tenantId]) ?>" title="Update" data-pjax="0"><span class="fa fa-tasks"></span> Permissions</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>                                
    </div>
</div>