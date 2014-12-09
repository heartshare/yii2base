<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\widgets;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/**
 * BaseLinkPager
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class BaseLinkPager extends LinkPager{

    // init html class for pagination wrapper
    public $options = ['class' => 'custom-pagination btn-group pull-right'];

    // init li items html class
    public $linkOptions = ['class' => 'btn btn-xs btn-default btn-pager'];

    // init next button label
    public $nextPageLabel = '<span class="fa fa-angle-right"></span>';

    // init previous button label
    public $prevPageLabel = '<span class="fa fa-angle-left"></span>';

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        $linkOptions = $this->linkOptions;
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $linkOptions['disabled'] = true;
            return Html::tag('li', Html::a($label, 'javascript:;', $linkOptions), $options);
        }
        $linkOptions['data-page'] = $page;

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }

}