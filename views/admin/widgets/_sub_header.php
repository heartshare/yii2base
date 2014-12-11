<?php
use yii\helpers\Html;
?>

<div class="header-row-wrapper">
  <div class="header-row">
      <header class="header-1">
          <h1 class="header-main" id="page-header">
                <?php
                    echo \gxc\yii2base\widgets\BaseBreadcrumbs::widget([
                        'links' => $breadcrumbs
                    ]);
                ?>
          </h1>
          <div class="header-right pull-right">
              <?php
                    if(!empty($buttons))
                        foreach($buttons as $button):
                            echo Html::a(isset($button['label'])?$button['label']:'', isset($button['url'])?$button['url']:'javascript:;', isset($button['options'])?$button['options']:[]);
                        endforeach;
              ?>
          </div>
      </header>
  </div>
</div>
