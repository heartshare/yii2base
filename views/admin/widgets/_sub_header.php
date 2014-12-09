<?php
use yii\helpers\Html;
?>

<header class="header-ctn col-md-12">
  <div class="header-row-wrapper">
      <header class="header-1">
          <h1 class="header-main" id="page-header" rel="">
                <?php
                    if(!empty($breadcrumbs)) {
                        $end_of_arr = count($breadcrumbs) - 1;
                        foreach ($breadcrumbs as $k => $item):
                            if (is_string($item)) {
                                echo $item;
                            } else {
                                if ($k == 0 && !empty($item['icon']))
                                    echo Html::tag('i', '', ['class' => $item['icon']]);

                                echo Html::beginTag('span', ['class' => 'breadcrumb']);
                                echo Html::a(isset($item['label']) ? $item['label'] : '', isset($item['url']) ? $item['url'] : 'javascript:;');
                                echo ($k != $end_of_arr)?' \\':'';
                                echo Html::endTag('span');
                            }
                        endforeach;
                    }
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
</header>
