<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\widgets;
use \Yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;

/**
 * Base Action Columns to render CURD buttons for base grid
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class BaseActionColumn extends ActionColumn
{

    // init default template
    public $template = '<div class="btn-group pull-right">{view} {update} {delete}</div>';


    // init default buttons
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url) {
                return Html::a('<span class="fa fa-eye"></span> ' . Yii::t('base', 'View'), $url, [
                    'title' => Yii::t('base', 'View'),
                    'data-pjax' => '0',
                    'class' => 'pull-left btn btn-xs btn-default'
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url) {
                return Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('base', 'Update'), $url, [
                    'title' => Yii::t('base', 'Update'),
                    'data-pjax' => '0',
                    'class' => 'pull-left btn btn-xs btn-default'
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url) {
                return Html::a('<span class="fa fa-trash-o"></span> ' . Yii::t('base', 'Delete'), $url, [
                    'title' => Yii::t('base', 'Delete'),
                    'data-confirm' => Yii::t('base', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'class' => 'pull-left btn btn-xs btn-default'
                ]);
            };
        }
    }

}