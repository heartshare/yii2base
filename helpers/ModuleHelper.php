<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\helpers;

use yii\helpers\ArrayHelper;
use \Yii;

/**
 * PlanHelper
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class ModuleHelper {

    public function getPlan($moduleId, $planId)
    {
        return self::getModule($moduleId)['plans'][$planId];
    }

    public function getPlans($moduleId)
    {
        if($moduleId === null)
            return [];
        return self::getModule($moduleId)['plans'];
    }

    public function getModule($moduleId)
    {
        return self::getModules()[$moduleId];
    }

    public function getAvailableModules($renderDropdown = false)
    {
        $modules = self::getModules();
        if($renderDropdown == false) {
            return $modules;
        } else {
            return ArrayHelper::map($modules, 'id', 'name');
        }
    }

    protected function getModules()
    {
        // improve with cache
        $cacheId = BaseHelper::getCacheKey('general', 'modules');
        $keys = Yii::$app->cache->get($cacheId);
        if ($keys === false) {

            // get all module dirs
            $moduleDirs = glob(\Yii::getAlias('@gxc') . '/*', GLOB_ONLYDIR);

            // init default application module values
            $modules = [
                'app' => [
                    'name' => 'Application Module',
                    'active' => true, //always true
                    'class' => 'yii\web\Application',
                    'path' => '@app',
                    'plans' => [],
                    'icon' => '',
                ],
            ];

            // parse module information
            foreach($moduleDirs as $moduleDir) {

                // check if exit having info.ini file, then parse it to get info
                if(file_exists($moduleDir . '/info.ini')) {

                    // get raw module info from ini file
                    $moduleRawInfo = parse_ini_file($moduleDir . '/info.ini');

                    // base module info
                    $module = [
                        'id' => $moduleRawInfo['id'],
                        'name' => $moduleRawInfo['name'],
                        'active' => boolval($moduleRawInfo['active']),
                        'class' => $moduleRawInfo['class'],
                        'path' => $moduleRawInfo['path'],
                        'icon' => '',
                    ];

                    // init plan values
                    $plans = [];

                    // get all plan dirs in current module, then get plan info
                    $planDirs = glob($moduleDir . '/plans/*', GLOB_ONLYDIR);
                    foreach($planDirs as $planDir) {
                        if(file_exists($planDir . '/info.ini')) {
                            $planRawInfo = parse_ini_file($planDir . '/info.ini');
                            $plans[$planRawInfo['id']] = [
                                'name' => $planRawInfo['name'],
                                'description' => $planRawInfo['description'],
                                'class' => $planRawInfo['class']
                            ];
                        }
                    }

                    // assign plan info to module values
                    $module['plans'] = $plans;

                    // assign module info to return array
                    $modules[$moduleRawInfo['id']] = $module;
                }
            }
            // set cache
            Yii::$app->cache->set($cacheId, $modules, BaseHelper::getCacheKeyTimeExpired('general', 'modules'));

            // reload
            $keys = Yii::$app->cache->get($cacheId);
        }
        return $keys;
    }
}