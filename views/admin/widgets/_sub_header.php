<?php
use yii\helpers\Html;
?>
<div class="row">
    <header class="breadcrumb-wrapper breadcrumb-with-filters">
        <?php
        echo \gxc\yii2base\widgets\BaseBreadcrumbs::widget([
            'links' => $breadcrumbs
        ]);
        ?>
        <div class="filters">
            <?php
            if(!empty($buttons)) {
                echo Html::beginTag('div', ['class'=>'form-group', 'style' => 'margin: 5px;']);
                foreach ($buttons as $button):
                    echo Html::a(isset($button['label']) ? $button['label'] : '', isset($button['url']) ? $button['url'] : 'javascript:;', isset($button['options']) ? $button['options'] : []) . "\n";
                endforeach;
                echo Html::endTag('div');
            }

            if(!empty($html))
                echo $html;
            ?>
        </div>
    </header>
</div>