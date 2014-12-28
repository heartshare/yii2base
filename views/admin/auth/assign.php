<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Nav;

$this->title = Yii::t('base', 'Permissions - {modelName}', [
    'modelName' => $tenant->name
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Auth'), 'url' => ['index'], 'icon'=>'fa fa-lock'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'][] = ['label' => Yii::t('base', 'Add module for this Tenant'), 'url' => ['add-module'], 'options' => ['class' => 'btn btn-success']];
?>

<div class="row">
    <header class="header-ctn col-md-12">
        <div class="brand-view">
            <h1>Tenant: GXCSOFT</h1>

            <p>http://gxcsoft.com</p>
        </div>
        <div class="summary-view">
            <ul>
                <li><a href="javascript:;">25</a><br/>Users</li>
                <li><a href="javascript:;">345 days</a><br/>Active</li>
                <li><a href="javascript:;">$234</a><br/>Contribution</li>
            </ul>
        </div>
    </header>
</div>

<div class="row">
    <section class="main-ctn">
        <div class="inner">
            <ul class="nav nav-tabs tabs-responsive" role="tablist">
                <li><a href="#general" role="tab" data-toggle="tab"><i class="fa fa-dashboard"></i>
                    General</a></li>
                <li><a href="#users" role="tab" data-toggle="tab"><i class="fa fa-users"></i>
                    Users</a></li>
                <li class="active"><a href="#permissions" role="tab" data-toggle="tab"><i class="fa fa-gears"></i> Permissions</a>
                </li>
                <li><a href="#modules" role="tab" data-toggle="tab"><i class="fa fa-tasks"></i> Modules</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane" id="general">
                    <div class="tab-ctn info-wrapper">
                        <div class="content-zone">

                            <div class="info-item">
                                <div class="info-item-header">
                                    <h1>Settings</h1>

                                    <div class="buttons pull-right">
                                        <a class="edit-button quick-edit-button" href=""><i class="fa fa-gear"></i> Edit</a>
                                    </div>
                                </div>
                                <div class="info-item-content">
                                    <span>Name</span>
                                    <span>GxcSoft</span>
                                </div>
                                <div class="info-item-content">
                                    <span>Website</span>
                                    <span>http://gxcsoft.com</span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-item-header">
                                    <h1>Contact Information</h1>

                                    <div class="buttons pull-right">
                                        <a class="edit-button quick-edit-button" href=""><i class="fa fa-gear"></i> Edit</a>
                                    </div>
                                </div>
                                <div class="info-item-content">
                                    <span>Email</span>
                                    <span>tungmv@gmail.com</span>
                                </div>
                                <div class="info-item-content">
                                    <span>Address</span>
                                    <span>Tung Mang Vien <br/>123 Quang Trung, Tan Binh <br/> Vietnam 10000</span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-item-header">
                                    <h1>Modules</h1>

                                    <div class="buttons pull-right">
                                        <a href="" class="quick-edit-button"><i class="fa fa-gear"></i> Edit or add new module</a>
                                    </div>
                                </div>
                                <table class="table table-hover tbl-1">
                                    <tbody>
                                    <tr>
                                        <td><img src="images/stack.png"/></td>
                                        <td style="width:20%;"><b>Base Module</b> <br> <span class="info-desc">Plan: Default</span>
                                        </td>
                                        <td>Expires in next 36 days <br> <span
                                                class="info-desc">15/03/2015</span></td>
                                        <td>
                                            <div class="pull-right">
                                                <a class="btn btn-default">Update</a> <a
                                                    class="btn btn-success">Renew</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="images/brightness.png"/></td>
                                        <td><b>Application Module</b> <br> <span
                                                class="info-desc">Plan: Default</span></td>
                                        <td>Expires in next 36 days <br> <span
                                                class="info-desc">15/03/2015</span></td>
                                        <td>
                                            <div class="pull-right">
                                                <a class="btn btn-default">Update</a> <a
                                                    class="btn btn-success">Renew</a>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="info-item">
                                <div class="info-item-header">
                                    <h1>Billing History</h1>

                                    <div class="buttons pull-right">
                                        <a href="" class="quick-edit-button">View all</a>
                                    </div>
                                </div>
                                <table class="table table-hover tbl-1">
                                    <tbody>
                                    <tr>
                                        <td><i class="fa fa-usd fa-2x" style="color:#428bca"></i></td>
                                        <td style="width:20%;">Payment made. Thanks</td>
                                        <td>2 days ago<br> <span class="info-desc">15/03/2015</span></td>
                                        <td>
                                            <div class="pull-right">
                                                $100
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-table fa-2x" style="color:#428bca"></i></td>
                                        <td>Invoice</td>
                                        <td>1 month ago <br> <span class="info-desc">15/03/2015</span></td>
                                        <td>
                                            <div class="pull-right">
                                                $150
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="users">
                    <div class="tab-ctn info-wrapper">
                        <div class="content-zone">
                            <div class="info-item">
                                <div class="info-item-header with-form-control grid-header">
                                    <h1>Users</h1>
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
                                                <button type="submit" class="btn btn-sm btn-warning"> ADD NEW USER <i
                                                        class="fa fa-plus fa-fw"></i>
                                                </button>
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
                                            <tr>
                                                <td><img src="images/noavatar.png" class="avatarImg" /></td>
                                                <td><a href="#"><strong>Thanh Truc</strong>

                                                    <p class="user-join-des info-small">Joined 2 days ago</p></td>
                                                <td>nganhtuan@gmail.com</td>
                                                <td style="width:20%;"  class="info-small">21/01/2014 02:02 PM</td>
                                                <td><span class="statusDot statusDot-success"></span></td>
                                                <td><span class="label label-danger">Owner</span></td>
                                                <td>
                                                    <div class="btn-group pull-right grid-action-buttons">
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-pencil"></span>
                                                            Update</a>
                                                        
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="<?= Url::toRoute(['/base/admin/auth/assign', 'type' => 'user', 'id' => 1, 'module' => isset($currentModule->module) ? $currentModule->module : 'app', 'tenant' => $tenantId]) ?>" title="Update"
                                                           data-pjax="0"><span class="fa fa-tasks"></span>
                                                            Permissions</a>
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/delete?id=1" title="Delete"
                                                           data-confirm="Are you sure you want to delete this item?"
                                                           data-method="post" data-pjax="0"><span
                                                                class="fa fa-trash-o"></span> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="images/avatar1.jpg" class="avatarImg" /></i></td>
                                                <td><a href="#"><strong>Die Nguyen </strong></a>

                                                    <p class="user-join-des info-small">Joined 20 days ago</p></td>
                                                <td>trietnguyen@gmail.com</td>
                                                <td style="width:20%;" class="info-small">21/01/2014 02:02 PM</td>
                                                <td><span class="statusDot statusDot-danger"></span></td>
                                                <td><span class="label label-success">Moderator</span></td>
                                                <td>
                                                    <div class="btn-group pull-right grid-action-buttons">
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-pencil"></span>
                                                            Update</a>
                                                       
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-tasks"></span>
                                                            Permissions</a>
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/delete?id=1" title="Delete"
                                                           data-confirm="Are you sure you want to delete this item?"
                                                           data-method="post" data-pjax="0"><span
                                                                class="fa fa-trash-o"></span> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="images/avatar2.jpg" class="avatarImg" /></i></td>
                                                <td><a href="#"><strong>Phuong Sex</strong></a>

                                                    <p class="user-join-des info-small">Joined 2 years ago</p></td>
                                                <td>tungmv@gmail.com</td>
                                                <td style="width:20%;"  class="info-small">21/01/2014 02:02 PM</td>
                                                <td><span class="statusDot statusDot-success"></span></td>
                                                <td><span class="label label-success">Moderator</span></td>
                                                <td>
                                                    <div class="btn-group pull-right grid-action-buttons">
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-pencil"></span>
                                                            Update</a>
                                                       
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-tasks"></span>
                                                            Permissions</a>
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/delete?id=1" title="Delete"
                                                           data-confirm="Are you sure you want to delete this item?"
                                                           data-method="post" data-pjax="0"><span
                                                                class="fa fa-trash-o"></span> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="images/avatar3.jpg" class="avatarImg" /></td>
                                                <td><a href="#"><strong>Tri Nguyen</strong></a>

                                                    <p class="user-join-des info-small">Joined 3 years ago</p></td>
                                                <td>trinm@gmail.com</td>
                                                <td style="width:20%;" class="info-small">21/01/2014 02:02 PM</td>
                                                <td><span class="statusDot statusDot-danger"></span></td>
                                                <td><span class="label label-default">Guest</span></td>
                                                <td>
                                                    <div class="btn-group pull-right grid-action-buttons">
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-pencil"></span>
                                                            Update</a>
                                                       
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-tasks"></span>
                                                            Permissions</a>
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/delete?id=1" title="Delete"
                                                           data-confirm="Are you sure you want to delete this item?"
                                                           data-method="post" data-pjax="0"><span
                                                                class="fa fa-trash-o"></span> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="images/avatar4.jpg" class="avatarImg" /></td>
                                                <td><a href="#"><strong>Travis</strong></a>

                                                    <p class="user-join-des info-small">Joined 20 days ago</p></td>
                                                <td>travis@gmail.com</td>
                                                <td style="width:20%;"  class="info-small">21/01/2014 02:02 PM</td>
                                                <td><span class="statusDot statusDot-success"></span></td>
                                                <td><span class="label label-default">Guest</span></td>
                                                <td>
                                                    <div class="btn-group pull-right grid-action-buttons">
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-pencil"></span>
                                                            Update</a>
                                                      
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/update?id=1" title="Update"
                                                           data-pjax="0"><span class="fa fa-tasks"></span>
                                                            Permissions</a>
                                                        <a class="pull-left btn btn-xs btn-default"
                                                           href="/base/admin/tenant/delete?id=1" title="Delete"
                                                           data-confirm="Are you sure you want to delete this item?"
                                                           data-method="post" data-pjax="0"><span
                                                                class="fa fa-trash-o"></span> Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="permissions">
                    <div class="tab-ctn info-wrapper">
                        <div class="content-zone">
                            <div class="info-item">
                                <?= $this->render('_permission_role', [
                                            'tenantId' => $tenantId,
                                            'modules' => $modules,
                                            'roleName' => $roleName,
                                            'rolePermissions' => $rolePermissions,
                                    ]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="modules">
                    <div class="tab-ctn info-wrapper">
                        <div class="content-zone">

                            <div class="info-item">

                                <div class="info-item-header with-form-control">
                                    <h1>Permissions / Roles</h1>
                                    <div class="buttons">
                                        <a class="btn btn-sm btn-warning"> ADD NEW MODULE <i class="fa fa-plus fa-fw"></i>
                                        </a>
                                    </div>
                                </div>
                                <table class="table table-hover tbl-1">
                                    <tbody>
                                    <tr>
                                        <td><img src="images/stack.png"/></td>
                                        <td style="width:20%;"><b>Base Module</b> <br> <span class="info-desc">Plan: Default</span>
                                        </td>
                                        <td>Expires in next 36 days <br> <span
                                                class="info-desc">15/03/2015</span></td>
                                        <td>Updated: Manual <br> <span
                                                class="info-desc">by: Tuan Nguyen at 16/03/2014</span></td>
                                        <td>
                                            <div class="btn-group pull-right grid-action-buttons">
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-pencil"></span>
                                                    Update</a>

                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-eye"></span>
                                                    Access</a>
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/delete?id=1" title="Delete"
                                                   data-confirm="Are you sure you want to delete this item?"
                                                   data-method="post" data-pjax="0"><span
                                                        class="fa fa-tasks"></span> Permissions</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="images/brightness.png"/></td>
                                        <td><b>Application Module</b> <br> <span
                                                class="info-desc">Plan: Default</span></td>
                                        <td>Expires in next 36 days <br> <span
                                                class="info-desc">15/03/2015</span></td>
                                        <td>Updated: Auto <br> <span
                                                class="info-desc">by: System at 20/02/2014</span></td>
                                        <td>
                                            <div class="btn-group pull-right grid-action-buttons">
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-pencil"></span>
                                                    Update</a>

                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-eye"></span>
                                                    Access</a>
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/delete?id=1" title="Delete"
                                                   data-confirm="Are you sure you want to delete this item?"
                                                   data-method="post" data-pjax="0"><span
                                                        class="fa fa-tasks"></span> Permissions</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="images/stack.png"/></td>
                                        <td style="width:20%;"><b>Base Module</b> <br> <span class="info-desc">Plan: Default</span>
                                        </td>
                                        <td>Expires in next 36 days <br> <span
                                                class="info-desc">15/03/2015</span></td>
                                        <td>Updated: Manual <br> <span
                                                class="info-desc">by: Tuan Nguyen at 16/03/2014</span></td>
                                        <td>
                                            <div class="btn-group pull-right grid-action-buttons">
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-pencil"></span>
                                                    Update</a>

                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-eye"></span>
                                                    Access</a>
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/delete?id=1" title="Delete"
                                                   data-confirm="Are you sure you want to delete this item?"
                                                   data-method="post" data-pjax="0"><span
                                                        class="fa fa-tasks"></span> Permissions</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="images/brightness.png"/></td>
                                        <td><b>Application Module</b> <br> <span
                                                class="info-desc">Plan: Default</span></td>
                                        <td>Expires in next 36 days <br> <span
                                                class="info-desc">15/03/2015</span></td>
                                        <td>Updated: Auto <br> <span
                                                class="info-desc">by: System at 20/02/2014</span></td>
                                        <td>
                                            <div class="btn-group pull-right grid-action-buttons">
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-pencil"></span>
                                                    Update</a>

                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-eye"></span>
                                                    Access</a>
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/delete?id=1" title="Delete"
                                                   data-confirm="Are you sure you want to delete this item?"
                                                   data-method="post" data-pjax="0"><span
                                                        class="fa fa-tasks"></span> Permissions</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="images/stack.png"/></td>
                                        <td style="width:20%;"><b>Base Module</b> <br> <span class="info-desc">Plan: Default</span>
                                        </td>
                                        <td>Expires in next 36 days <br> <span
                                                class="info-desc">15/03/2015</span></td>
                                        <td>Updated: Manual <br> <span
                                                class="info-desc">by: Tuan Nguyen at 16/03/2014</span></td>
                                        <td>
                                            <div class="btn-group pull-right grid-action-buttons">
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-pencil"></span>
                                                    Update</a>

                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-eye"></span>
                                                    Access</a>
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/delete?id=1" title="Delete"
                                                   data-confirm="Are you sure you want to delete this item?"
                                                   data-method="post" data-pjax="0"><span
                                                        class="fa fa-tasks"></span> Permissions</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="images/brightness.png"/></td>
                                        <td><b>Application Module</b> <br> <span
                                                class="info-desc">Plan: Default</span></td>
                                        <td>Expires in next 36 days <br> <span
                                                class="info-desc">15/03/2015</span></td>
                                        <td>Updated: Auto <br> <span
                                                class="info-desc">by: System at 20/02/2014</span></td>
                                        <td>
                                            <div class="btn-group pull-right grid-action-buttons">
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-pencil"></span>
                                                    Update</a>

                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/update?id=1" title="Update"
                                                   data-pjax="0"><span class="fa fa-eye"></span>
                                                    Access</a>
                                                <a class="pull-left btn btn-xs btn-default"
                                                   href="/base/admin/tenant/delete?id=1" title="Delete"
                                                   data-confirm="Are you sure you want to delete this item?"
                                                   data-method="post" data-pjax="0"><span
                                                        class="fa fa-tasks"></span> Permissions</a>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>