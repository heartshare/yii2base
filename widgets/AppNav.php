<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\DropDown;

/** 
 * Custom Navigation Bar for Application Layout
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class AppNav extends Nav
{
	
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();
		Html::removeCssClass($this->options, 'nav');
	}

	/**
	* @inheritdoc
	*/
	public function renderItem($item)
	{
		if (is_string($item)) {
			return $item;
		}		
		if (!isset($item['label'])) {
		 	throw new InvalidConfigException("The 'label' option is required.");
		}

		// If it uses icon or label, we need to render HTML for the item
		if (isset($item['icon']) && isset($item['label'])) {
			if($item['label']!='divider'){
				$class = isset($item['icon']) ? 'class="fa fa-'.$item['icon'].'"' : '';
				$item['label'] = '<i '.$class.'></i><span">'.$item['label'].'</span>';
			}
			
		}

		$label = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
		$options = ArrayHelper::getValue($item, 'options', []);
		$items = ArrayHelper::getValue($item, 'items');
		$url = ArrayHelper::getValue($item, 'url', '#');
		$linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);		

		if (isset($item['active'])) {
			$active = ArrayHelper::remove($item, 'active', false);
		} else {
			$active = $this->isItemActive($item);
		}

		if ($active) {
			Html::addCssClass($options, 'active');
		}

		if ($items !== null) {			
			if (is_array($items)) {
				$linkOptions = ArrayHelper::getValue($item, 'linkOptions', ['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']);
				$items = AppNav::widget([
					'options' => ['class' => 'dropdown-menu dropdown-menu-style'],
					'items' => $items,
					'encodeLabels' => $this->encodeLabels,
					'clientOptions' => false,
					'view' => $this->getView(),
				]);
			}
		}

		return $label!='divider' ? Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options) :  Html::tag('li', '', $options);
	}
}
