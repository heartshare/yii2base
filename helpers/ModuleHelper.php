<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\helpers;

use yii\helpers\ArrayHelper;
use \Yii;
use yii\helpers\FileHelper;

/**
 * ModuleHelper
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class ModuleHelper {

    public function getPlan($moduleId, $planId)
    {
        return self::getModule($moduleId)['plans'][$planId];
    }

    public function getPlans($moduleId, $renderDropdown = false)
    {
        if($moduleId === null)
            return [];

        if($renderDropdown === true)
            return ArrayHelper::map(self::getModule($moduleId)['plans'], 'id', 'name');
        else
            return self::getModule($moduleId)['plans'];
    }

    public function getModule($moduleId)
    {
        if($moduleId == '')
            return [];
        return self::getAvailableModules()[$moduleId];
    }

    public function getAvailableModules($renderDropdown = false)
    {
        $modules = self::getModules();
        if($renderDropdown === false) {
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
                    'id' => 'app',
                    'name' => 'Application Module',
                    'description' => 'This is main application module. Which is System Module.',
                    'active' => true, //always true
                    'class' => 'yii\web\Application',
                    'path' => '@app',
                    'plans' => [],
                    'icon' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAQVQTFRFAAAAx1xcx1xcx1xcx1xcx1xcx1xcx1xcx1xcx1xcx1xcx1xcx1xcplBQqFFRqlJSqllYrFJSrFtbsFRUsWZmsWtoslVVtFVVtXRwt1ZWt3FxuH14uVdXurmuu1hYvGFhvLuwvVhYv1lZv4+IwVpawXFuwmJhw1tbw5iRw8K4xMO3xVtbx1xcx3d3x6GZx8a9yMi7yWRjyYN+ynRxy2Zmy5uUzHVyzX15znBwzrOpz4WBz8/C0I6I0JWO0nt70paP06io1J6X1NPM1cW52JiY2Les2c7B28e729vN3JmZ3NfJ3dDC3dzX4ODR466u7t7e9Onp9eDg9vb1+Ovr+fT0/PX1////n/cJdQAAAA10Uk5TABAgMEBQYICfr7/P7+UGBHAAAAM3SURBVFjDvVfrWuIwEKXKVRgroEK5KQUVJd4VEBFBBEVMFdG+/6NsAhTaJmnrx+6eX6Wdc0hmJjMTn08AfygSRXNEIyG/7zeQghHEIBKUPNL9YSRAeN0LfQM5YMNtK1IYuSDsuJFADLkiFhDzw8gTwqLlR5FHRKXV+HyFtRj6BWKSx/9vYtz0tgbB+rsYdwW7cPL/ZavGCtRal+JYBKzqfYzrdoE6xn2rlSkfJJsDXzB+mT1dYXy1eDcSOtKeQLfY8N0ugGJ4E9+KEspvd1B8YOyhCFA0BAay3c44Wcz5U3YqJcprDzWCYZsqlSo7CnM2Z/x1NkYygNrQJvocE61BliKzdn7RESore5pugbanlAXHSjLFvz+aB6091m0Yt+eBHfVN+UADEVz+bBFXj2gOtX90Bj9UoTYiJq0lI0gETPXzmnylicPjzxS61OLaVGmJgGlLhXQP4wd0M9a5GN+gB4x76YKJYk2CMkA2rSBNF0BDSjoLULbEIWT2qhoHyDV0IRo5gLhqZoR8thZSVMULoEtQi7Z2wykEE7HAhFMWmFdt3QFtxpwVGDoJDJ0Emt1ulxxizUlAW5hxBGiOYHeBudk/EKhmK5VK1lXAMOMIAAVCz04CzwszzhaKiqKQNDl1EjhdmC0EmERSPsX8T4VNJGYaUjtigY7KTE7WwzT1xbZYYLtqtw7Za3qzjpLCJXSSqNlkyqr5Z530n8dC4oPP/0gUHknPqlsy2VLSarOSJme+efzvjDwraTVrSbMV1cEBUoGn8J0BFR0M2KJqKuuHd70K7YUpyDC7+MhAisQYKoO7Q2tZNzWWAskxuTztqQmbJzsJ2KVVk/QsKNja6zIO1WR8nimkKx+/fxnsr/djmPJpnsnJZSzXBc2VILeZz+fPn94Jns7J42aON/iK2jvF0UXehIsjno3fcULFr/cn+5S8f3L/ip0nVok3I2ILXGbFAOf7mZl/xjEIuIzZkB4Y9EEaXEdutr+kAEpvlP5WAppDzoMmb9RVZdgi+zjbAln1MG7zHJnbBNgCXgrE1ryN+1Wyj1R1tQtD1fOFY/Urz1+4dK1+7Vv94jkdfcVXX///uXz/7vr/B7aPmbJ/KGvwAAAAAElFTkSuQmCC',
                ],
            ];

            // parse module information
            foreach($moduleDirs as $moduleDir) {

                // check if exit having info.ini file, then parse it to get info
                if(file_exists($moduleDir . '/info.ini')) {

                    // get raw module info from ini file
                    $moduleRawInfo = parse_ini_file($moduleDir . '/info.ini');

                    // get icon
                    $icon = '';
                    if(file_exists($moduleDir . '/icon.png') && in_array(FileHelper::getMimeType($moduleDir . '/icon.png'), ['image/jpg', 'image/png', 'image/jpeg'])){
                        $icon = 'data:'.FileHelper::getMimeType($moduleDir . '/icon.png').';base64,' . base64_encode(file_get_contents($moduleDir . '/icon.png', null, null, null, 1000000)); // max is 1MB
                    }

                    // base module info
                    $module = [
                        'id' => $moduleRawInfo['id'],
                        'name' => $moduleRawInfo['name'],
                        'description' => $moduleRawInfo['description'],
                        'active' => boolval($moduleRawInfo['active']),
                        'class' => $moduleRawInfo['class'],
                        'path' => $moduleRawInfo['path'],
                        'icon' => $icon,
                    ];

                    // init plan values
                    $plans = [];

                    // get all plan dirs in current module, then get plan info
                    $planDirs = glob($moduleDir . '/plans/*', GLOB_ONLYDIR);
                    foreach($planDirs as $planDir) {
                        if(file_exists($planDir . '/info.ini')) {
                            $planRawInfo = parse_ini_file($planDir . '/info.ini');
                            $plans[$planRawInfo['id']] = [
                                'id' => $planRawInfo['id'],
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