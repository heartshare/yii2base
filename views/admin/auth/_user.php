<?php

use yii\helpers\Url;
?>

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