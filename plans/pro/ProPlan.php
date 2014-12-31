<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\plans\basic;

use gxc\yii2base\classes\PlanTemplate;
use yii\helpers\FileHelper;

/**
 * BasicPlan
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class ProPlan implements PlanTemplate
{
    public function check($params)
    {
        return true;
    }

    /**
     * get plan information
     *
     * @param array $params
     * @return array
     */
    public function getInfo($params = [])
    {
        $fileInfo = dirname(__DIR__) . '/info.ini';
        $planInfo = parse_ini_file($fileInfo);

        if (!empty($params)) {
            $result = [];
            foreach($params as $param){
                $result[$param] = !empty($planInfo[$param])?$planInfo[$param]:'';
            }
            return $result;
        } else {
            return $planInfo;
        }
    }

    public function setInfo($params = [])
    {
//        [
//            'app' => [
//                'name' => 'Application Module',
//                'active' => true, //always true
//                'class' => 'yii\web\Application',
//                'path' => '@app'
//            ],
//
//            'base' => [
//                'name' => 'Base Module',
//                'active' => true, // True or False based on Config
//                'class' => 'gxc\yii2base\Module',
//                'path' => '@gxc/yii2base'
//            ],
//        ]
    }
}