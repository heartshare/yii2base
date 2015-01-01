<?php

use yii\helpers\Html;

$this->title = Yii::t('base', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]) . ' ' . $model->id;
$this->params['formId'] = 'user-create-form';
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
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
                
                echo \gxc\yii2base\widgets\BaseTabs::widget([
                    'items' => [
                        [
                            'label' => '<i class="fa fa-dashboard"></i> General',
                            // 'link' => ['view', 'id' => $tenant->id],
                        ],
                        [
                            'label' => '<i class="fa fa-users"></i> Users',
                            'content' => $this->render('_form', ['model' => $model, 'staffZoneRoles' => $staffZoneRoles, 'guestZoneRoles' => $guestZoneRoles, 'formId' => $this->params['formId']]),
                            'active' => true
                        ],
                        [
                            'label' => '<i class="fa fa-gears"></i> Permissions',
                            // 'link' => ['index', 'id' => $tenant->id],
                        ],
                        [
                            'label' => '<i class="fa fa-tasks"></i> Modules',
                            'link' => ['auth/index/assign'],
                        ]
                    ]
                ]);
            ?>
        </div>
    </section>
</div>