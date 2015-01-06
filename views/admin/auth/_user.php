<?php

use yii\helpers\Url;
use gxc\yii2base\models\user\UserIdentity;
?>

<div class="tab-ctn info-wrapper">
    <div class="content-zone">
        <div class="info-item">
            <div class="info-item-header with-form-control grid-header">
                <h1><?= \Yii::t('base', 'Users'); ?></h1>
                <div class="buttons-with-filters">
                    <form id="tenant-search-form" class="form-inline"
                          action="/base/admin/tenant/index" method="get">

                        <div class="form-group">
                            <input type="text" id="tenantsearch-keywords"
                                   class="form-control input-sm"
                                   name="TenantSearch[keywords]"
                                   placeholder="Search Keywords in ...">
                        </div>
                        <div class="form-group">
                            <select class="form-control input-sm"
                                    name="TenantSearch[field]">
                                <option value="all">All Status</option>
                                <option value="name">Name</option>
                                <option value="domain">Domain</option>
                                <option value="system_domain">System Domain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control input-sm"
                                    name="TenantSearch[field]">
                                <option value="all">All Fields</option>
                                <option value="name">Name</option>
                                <option value="domain">Domain</option>
                                <option value="system_domain">System Domain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <a href="<?= Url::toRoute(['admin/user/create']) ?>" class="btn btn-sm btn-warning"> <?= Yii::t('base', 'ADD NEW USER') ?> <i class="fa fa-plus fa-fw"></i></a>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row section section-first section-data">
                <div class="table-responsive" style="margin-top: 10px;">
                    <table class="table table-hover tbl-grid">
                        <thead>
                            <tr>
                                <th></th>
                                <th><a href="">Name</a></th>
                                <th><a href="">Email</a></th>
                                <th><a href="">Recent Login</a></th>
                                <th><a href="">Status</a></th>
                                <th><a href="">Access Level</a></th>
                                <th>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><img src="images/noavatar.png" class="avatarImg" /></td>
                                <td>
                                    <a href="#"><strong><?= isset($user->displayInfo->display_name) ? $user->displayInfo->display_name : '' ?></strong>
                                    <p class="user-join-des info-small">Joined 2 days ago</p>
                                </td>
                                <td><?= $user->email ?></td>
                                <td style="width:20%;"  class="info-small">21/01/2014 02:02 PM</td>
                                <td>
                                    <?php if (isset($user->identityInfo->status) && $user->identityInfo->status == UserIdentity::STATUS_ACTIVE): ?>
                                    <span class="statusDot statusDot-success"></span>
                                    <?php else: ?>
                                    <span class="statusDot statusDot-danger"></span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="label label-danger">Owner</span></td>
                                <td>
                                    <div class="btn-group pull-right grid-action-buttons">
                                        <a class="pull-left btn btn-xs btn-default" href="<?= Url::toRoute(['admin/user/update', 'id' => $user->id, 'identity' => $user->identityInfo->zone]) ?>" title="Update" data-pjax="0"><span class="fa fa-pencil"></span>Update</a>
                                        <a class="pull-left btn btn-xs btn-default" href="<?= Url::toRoute(['admin/auth/assign', 'id' => $user->id, 'identity' => $user->identityInfo->zone, 'type' => 'user', 'module' => isset($currentModule->module) ? $currentModule->module : 'app', 'tenant' => $tenantId]) ?>" title="Update" data-pjax="0"><span class="fa fa-tasks"></span>Permissions</a>
                                        <a class="pull-left btn btn-xs btn-default" href="<?= Url::toRoute(['admin/user/delete', 'id' => $user->id]) ?>" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0"><span class="fa fa-trash-o"></span> Delete</a>
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