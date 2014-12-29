<?php if(!empty($model)): ?>
<div class="row">
    <header class="header-ctn col-md-12">
        <div class="brand-view">
            <h1>
                <?= Yii::t('base', 'Tenant') . ": " . $model->name;?>
                <?= \gxc\yii2base\models\tenant\Tenant::renderTenantStatus($model->status); ?>
            </h1>
            <p><?= $model->domain ?></p>
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
            if($mode == 'view') {
                echo \gxc\yii2base\widgets\BaseTabs::widget([
                    'items' => [
                        [
                            'label' => '<i class="fa fa-dashboard"></i> General',
                            'content' => $this->render('_general', ['model' => $model]),
                            'active' => true
                        ],
                        [
                            'label' => '<i class="fa fa-users"></i> Users',
                            'link' => ['auth/type/user'],
                        ],
                        [
                            'label' => '<i class="fa fa-gears"></i> Permissions',
                            'link' => ['auth/type/role'],
                        ],
                        [
                            'label' => '<i class="fa fa-tasks"></i> Modules',
                            'link' => ['auth/index/assign'],
                        ]
                    ]
                ]);
            } else if ($mode == 'contact') {
                echo \gxc\yii2base\widgets\BaseTabs::widget([
                    'items' => [
                        [
                            'label' => '<i class="fa fa-dashboard"></i> General',
                            'content' => $this->render('_contact', ['model' => $contact, 'tenant' => $model]),
                            'active' => true
                        ],
                        [
                            'label' => '<i class="fa fa-users"></i> Users',
                            'link' => ['auth/type/user'],
                        ],
                        [
                            'label' => '<i class="fa fa-gears"></i> Permissions',
                            'link' => ['auth/type/role'],
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
<?php endif; ?>