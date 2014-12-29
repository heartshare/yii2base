<div class="tab-ctn info-wrapper">
    <div class="content-zone">

        <div class="info-item">
            <div class="info-item-header">
                <h1><?= Yii::t('base', 'Settings') ?></h1>

                <div class="buttons pull-right">
                    <?= \yii\helpers\Html::a('<i class="fa fa-gear"></i> ' . Yii::t('base', 'Edit'), ['update', 'id' => $model->id], ['class' => 'edit-button quick-edit-button']) ?>
                </div>
            </div>
            <div class="info-item-content">
                <span>Name</span>
                <span><?= $model->name ?></span>
            </div>
            <div class="info-item-content">
                <span>Website</span>
                <span><?= $model->domain ?></span>
            </div>
            <div class="info-item-content">
                <span>Owner email</span>
                <span><?= $model->account->email ?></span>
            </div>
        </div>

        <div class="info-item">
            <div class="info-item-header">
                <h1><?= Yii::t('base', 'Contact Information') ?></h1>

                <div class="buttons pull-right">
                    <?= \yii\helpers\Html::a('<i class="fa fa-gear"></i> ' . Yii::t('base', 'Edit'), ['contact-update', 'id' => $model->id], ['class' => 'edit-button quick-edit-button']) ?>
                </div>
            </div>
            <div class="info-item-content">
                <span>Email</span>
                <span><?= isset($model->address->email) ? $model->address->email : Yii::t('base', 'not set') ?></span>
            </div>
            <div class="info-item-content">
                <span>Address</span>
                <span><?= \gxc\yii2base\models\tenant\Tenant::renderAddress($model); ?></span>
            </div>
        </div>

        <div class="info-item">
            <div class="info-item-header">
                <h1><?= Yii::t('base', 'Modules') ?></h1>

                <div class="buttons pull-right">
                    <a href="" class="quick-edit-button"><i class="fa fa-gear"></i> <?= Yii::t('base', 'Edit or add new module') ?></a>
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