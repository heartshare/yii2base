<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2015 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\widgets;
use yii\web\JsExpression;
use yii\widgets\InputWidget;
use yii\helpers\Html;

/**
 * TimeFromX
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class TimeFromX extends InputWidget {

    public $prefix = 'duration_';
    public $target;
    public $template = '{time}';


    public function run()
    {
        echo Html::tag('p', Html::hiddenInput($this->name, $this->value, ['id' => $this->prefix . $this->id]), $this->options);

        // check if not set target HTML element id
        // set target id is current hidden input
        if (empty($target))
            $this->target = '"#'.$this->prefix.$this->id.'"';

        // register js on document ready to parse by moment.js
        // we use moment.js fromNow from unix timestamp to optimize
        // http://momentjs.com/docs/#/displaying/fromnow/
        $time = str_replace('{time}', '"+moment.unix($("#' . $this->prefix . $this->id . '").val()).fromNow()+"', $this->template);
        $durationJs = new JsExpression('
            $(' . $this->target . ').parent().html("<span>'.$time.'</span>");
        ');
        $view = $this->getView();
        $view->registerJs($durationJs);
    }


}