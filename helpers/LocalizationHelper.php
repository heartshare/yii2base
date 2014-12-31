<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\helpers;

use \Yii;
use yii\helpers\ArrayHelper;

/**
 * AddressHelper
 *
 * @author Tung Mang Vien <tungmv7@gmail.com>
 * @since 2.0
 */
class LocalizationHelper {



    public static function getCity($code)
    {

    }

    public static function getCities($country)
    {

    }

    /**
     * get all state details from country code and state code
     *
     * @param $countryCode
     * @param $stateCode
     * @return mixed
     */
    public static function getState($countryCode, $stateCode)
    {
        $countryCode = strtolower($countryCode);
        $stateCode = strtolower($stateCode);
        $states = self::getStates($countryCode);
        return $states[$stateCode];
    }

    /**
     * get state list of country code
     * render dropdownlist data provider or just get state data
     *
     * @param $countryCode
     * @param bool $renderDropdown
     * @return array
     */
    public static function getStates($countryCode, $renderDropdown = false)
    {

        if(is_null($countryCode))
            return [];

        $countryCode = strtolower($countryCode);
        $country = self::getCountry($countryCode);
        if ($renderDropdown === false)
            return $country['states'];
        else
            return ArrayHelper::map($country['states'], 'id', 'name');
    }

    /**
     * get country details by country code
     *
     * @param $code
     * @return mixed
     */
    public static function getCountry($code)
    {
        $code = strtolower($code);
        $countries = self::getLocalization();
        return $countries[$code];
    }

    /**
     * get country list
     * render dropdownlist data provider or just get country data
     *
     * @param bool $renderDropdown
     * @return array
     */
    public static function getCountries($renderDropdown = false)
    {
        $countries = self::getLocalization();
        if ($renderDropdown === false) {
            return $countries;
        } else {
            return ArrayHelper::map($countries, 'id', 'name');
        }
    }

    /**
     * get all localization supported by xml files
     *
     * @return array|bool
     */
    public static function getLocalization()
    {
        // improve with cache
        $cacheId = BaseHelper::getCacheKey('general', 'localization');
        $keys = Yii::$app->cache->get($cacheId);
        if ($keys === false) {

            // get all xml files on localization dir
            $localization_files = dirname(__DIR__) . '/localization/*.xml';

            // init countries arr
            $countries = [];
            foreach (glob($localization_files) as $xml_file) {
                $country = simplexml_load_file($xml_file);

                $states = [];
                if (!empty($country->states))
                    foreach ($country->states->state as $k => $state) {
                        $states[(string)$state['iso_code']] = [
                            'id' => (string)$state['iso_code'],
                            'name' => (string)$state['name']
                        ];
                    }

                $countries[basename($xml_file, '.xml')] = [
                    'id' => basename($xml_file, '.xml'),
                    'name' => (string)$country['name'],
                    'taxes' => [],
                    'states' => $states
                ];
            }

            // set cache
            Yii::$app->cache->set($cacheId, $countries, BaseHelper::getCacheKeyTimeExpired('general', 'localization'));

            // reload
            $keys = Yii::$app->cache->get($cacheId);
        }
        return $keys;
    }
}