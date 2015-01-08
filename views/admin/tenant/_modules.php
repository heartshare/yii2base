<div class="tab-ctn info-wrapper">
    <div class="content-zone">
        <div class="info-item">

            <div class="info-item-header with-form-control grid-header">
                <h1><?= Yii::t('base', 'Modules / Manage') ?></h1>
                <div class="buttons">
                    <?= \yii\helpers\Html::a(Yii::t('base', 'Add new Module') . ' <i class="fa fa-plus fa-fw"></i>',
                        ['module-form', 'tid' => $tenant->id, 'mid' => 0],
                        [
                            'class' => 'btn btn-sm btn-warning', 'style' => 'margin:5px;',
                            'data-toggle' => 'modal',
                            'data-target' => '#module-form'
                        ])
                    ?>
                </div>
            </div>
            <div class="row section section-first section-data">
                <?php
                    \yii\widgets\Pjax::begin(['id' => 'tenant-modules',]);
                    echo \gxc\yii2base\widgets\BaseGridView::widget([
                        'dataProvider' => $modules,
                        'options' => ['class' => ''],
                        'showHeader' => false,
                        'columns' => [
                            [
                                'class'=>'yii\grid\DataColumn',
                                'attribute' => 'logo',
                                'content' => function ($model){
                                    return \yii\helpers\Html::img($model->getModuleLogo($model->module));
                                }
                            ],
                            [
                                'class'=>'yii\grid\DataColumn',
                                'options' => ['style' => 'width:20%;'],
                                'attribute' => 'module',
                                'content' => function ($model) use ($tenant){
                                    return $model->getModuleInfo($tenant->id, $model);
                                }
                            ],
                            [
                                'class'=>'yii\grid\DataColumn',
                                'attribute' => 'expired_at',
                                'content' => function ($model){
                                    return $model->renderExpiredAt($model);
                                }
                            ],
                            [
                                'class'=>'yii\grid\DataColumn',
                                'attribute' => 'updated_by',
                                'content' => function ($model){
                                    return $model->renderUpdatedBy($model);
                                }
                            ],
                            [
                                'class' => 'gxc\yii2base\widgets\BaseActionColumn',
                                'template' => '<div class="btn-group pull-right">{update} {access} {permissions}</div>',
                                'buttons' => [
                                    'update' => function ($url, $model) use ($tenant) {
                                        return \yii\helpers\Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('base', 'Update'),
                                            ['module-form', 'mid' => $model->id, 'tid' => $tenant->id],
                                            [
                                                'data-toggle' => 'modal',
                                                'data-target' => '#module-form',
                                                'title' => Yii::t('base', 'Update'),
                                                'class' => 'pull-left btn btn-xs btn-default'
                                            ]
                                        );
                                    },
                                    'access' => function ($url, $model) use ($tenant) {
                                        return \yii\helpers\Html::a('<span class="fa fa-eye"></span> ' . Yii::t('base', 'Access'),
                                            ['admin/access', 'mid' => $model->id, 'tid' => $tenant->id],
                                            [
                                                'title' => Yii::t('base', 'Access'),
                                                'class' => 'pull-left btn btn-xs btn-default'
                                            ]
                                        );
                                    },
                                    'permissions' => function ($url, $model) use ($tenant) {
                                        return \yii\helpers\Html::a('<span class="fa fa-tasks"></span> ' . Yii::t('base', 'Permissions'),
                                            ['admin/permission', 'mid' => $model->id, 'tid' => $tenant->id],
                                            [
                                                'title' => Yii::t('base', 'Permissions'),
                                                'class' => 'pull-left btn btn-xs btn-default'
                                            ]
                                        );
                                    }
                                ]
                            ],
                        ]
                    ]);
                    \yii\widgets\Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>

<!-- module form on popup -->
<div id="module-form" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">

        </div>
    </div>
</div>