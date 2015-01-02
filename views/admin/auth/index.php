<?php

use yii\helpers\Html;
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
            <?php
                if (isset($_GET['type']) && $_GET['type'] == 'user') {
                    echo \gxc\yii2base\widgets\BaseTabs::widget([
                        'items' => [
                            [
                                'label' => '<i class="fa fa-dashboard"></i> General',
                                'link' => ['view', 'id' => $tenant->id],
                            ],
                            [
                                'label' => '<i class="fa fa-users"></i> Users',
                                'content' => $this->render('_user', ['tenantId' => $tenant->id, 'roles' => $roles, 'users' => $users]),
                                'active' => true
                            ],
                            [
                                'label' => '<i class="fa fa-gears"></i> Permissions',
                                'link' => ['index', 'id' => $tenant->id],
                            ],
                            [
                                'label' => '<i class="fa fa-tasks"></i> Modules',
                                'link' => ['auth/index/assign'],
                            ]
                        ]
                    ]);
                } else {
                    echo \gxc\yii2base\widgets\BaseTabs::widget([
                        'items' => [
                            [
                                'label' => '<i class="fa fa-dashboard"></i> General',
                                'link' => ['view', 'id' => $tenant->id],
                            ],
                            [
                                'label' => '<i class="fa fa-users"></i> Users',
                                'link' => ['', 'type' => 'user'],
                            ],
                            [
                                'label' => '<i class="fa fa-gears"></i> Permissions',
                                'content' => $this->render('_role', ['tenantId' => $tenant->id, 'roles' => $roles]),
                                'active' => true
                            ],
                            [
                                'label' => '<i class="fa fa-tasks"></i> Modules',
                                'link' => ['auth/index/assign'],
                            ]
                        ]
                    ]);
                }
            ?>
        </div>
    </section>
</div>