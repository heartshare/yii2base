<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\classes;

/**
 * PlanTemplate
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
interface PlanTemplate {

    /**
     * @param $params
     * @return mixed
     */
    public function check($params);

    public function getInfo($params = []);

    public function setInfo($params = []);
}