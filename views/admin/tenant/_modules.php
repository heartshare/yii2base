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
                                'content' => function ($model){
                                    return $model->getModuleInfo($model);
                                }
                            ],
                            [
                                'class'=>'yii\grid\DataColumn',
                                'attribute' => 'update_time',
                                'content' => function ($model){
                                    return \gxc\yii2base\models\tenant\TenantModule::renderUpdateTime($model);
                                }
                            ],
                            [
                                'class' => 'gxc\yii2base\widgets\BaseActionColumn',
                                'template' => '<div class="btn-group pull-right">{view} {update} {delete}</div>',
                            ],
                        ]
                    ])

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