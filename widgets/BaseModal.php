<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\widgets;

use yii\bootstrap\Modal;
use yii\helpers\Html;

/**
 * BaseModal
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class BaseModal extends Modal
{

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-dialog
        echo "\n" . Html::endTag('div');

        $this->registerPlugin('modal');
    }

    /**
     * Renders the header HTML markup of the modal
     * @return string the rendering result
     */
    protected function renderHeader()
    {
        $button = $this->renderCloseButton();
        if ($button !== null) {
            $this->header = $button . "\n" . $this->header;
        }
        if ($this->header !== null) {
            Html::addCssClass($this->headerOptions, 'modal-header');
            return Html::tag('div', "\n" . Html::tag('h4', $this->header, ['class' => "modal-title"]) . "\n", $this->headerOptions);
        } else {
            return null;
        }
    }

    protected function renderFooter()
    {
        if ($this->footer !== null) {
            Html::addCssClass($this->footerOptions, 'modal-footer');
            return Html::tag('div', "\n" . $this->footer . "\n", $this->footerOptions);
        } else {
            return null;
        }
    }
}