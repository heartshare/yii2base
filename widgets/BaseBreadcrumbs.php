<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\widgets;

use \Yii;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/**
 * BaseBreadcrumbs
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class BaseBreadcrumbs extends Breadcrumbs{

    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }

        echo Html::tag($this->tag, implode('', $links), $this->options);
    }

    protected function renderItem($link, $template)
    {
        if (isset($link['label'])) {
            $label = $this->encodeLabels ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }


        $issetTemplate = isset($link['template']);
        if (isset($link['url'])) {
            $result = strtr($issetTemplate ? $link['template'] : $template, ['{link}' => Html::a($label, $link['url'])]);
        } else {
            $result = strtr($issetTemplate ? $link['template'] : $template, ['{link}' => $label]);
        }

        if(isset($link['icon']))
            $result = '<i class="'.$link['icon'].'"></i> '. $result;

        return $result;

    }

}