<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\widgets;
use yii\grid\GridView;

/**
 * BaseGridView
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class BaseGridView extends GridView{

    // init html class for div wrapper
    public $options = ['class' => 'col-md-12'];

    // init html class for table tag
    public $tableOptions = ['class' => 'table table-hover tbl-1'];

    // init html element position orders
    public $layout = "{items}\n<div class='addition-wrapper'>{summary}\n{pager}</div>";

    // init html class for summary
    public $summaryOptions = ['class' => 'custom-summary pull-left', 'style' => 'padding-left:23px;'];

    // init pager
    public $pager = ['class' => 'gxc\yii2base\widgets\BaseLinkPager'];

}