<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="col-md-12">
    <?php $form = ActiveForm::begin([
        'id' => 'tenant-search-form',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline']
    ]); ?>
        <div class="form-group">
            <?= Html::activeInput('text', $model, 'keywords', ['class' => 'form-control input-sm', 'placeholder' => Yii::t('base', 'Search Keywords in ...')]) ?>
            <?= Html::activeDropDownList($model, 'field', $model->getTenantSearchFields(), ['class' => 'form-control input-sm']) ?>
            <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-sm btn-warning']) ?>
        </div>
        <div class="form-group" style="display: block;">
            <ul class="list-filter list-inline">
                <li><a href="javascript:;" onclick="tenantQuickFilter('all');" class="fall">All</a></li>
                <li><a href="javascript:;" onclick="tenantQuickFilter('active');" class="factive">Active</a></li>
                <li><a href="javascript:;" onclick="tenantQuickFilter('inactive');" class="finactive">Inactive</a></li>
            </ul>
            <?= Html::activeHiddenInput($model, 'status'); ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
$js_filter_submit = '
    function tenantQuickFilter(status, obj){
        $target_status_input = $("#'.Html::getInputId($model, 'status').'");
        $target_status_input.val(status);
        $("#tenant-search-form").submit();
    };
';
Yii::$app->view->registerJs($js_filter_submit, \yii\web\View::POS_END);

$js_filter = "var current_status = getParameterByName('" . urlencode(Html::getInputName($model, 'status')) . "');
    switch(current_status){
        case 'all':
            $('.fall').attr('class', 'fall activated');
            break;

        case 'active':
            $('.factive').attr('class', 'factive activated');
            break;

        case 'inactive':
            $('.finactive').attr('class', 'finactive activated');
            break;

        default:
            $('.fall').attr('class', 'fall activated');
            break;
    }";
Yii::$app->view->registerJs($js_filter);

?>