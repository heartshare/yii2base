<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2app/
 */

namespace gxc\yii2base\helpers;

use Yii;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

use yii\base\InvalidConfigException;

/**
 * Base Helper Class 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class BaseHelper
{   
	/**
	 * Whether we are running in Consolde mode or not
	 * @return [boolean] 
	 */
	public static function getIsConsole()
	{
		return get_class(\Yii::$app)=='yii\console\Application';
	}

	/**
	 * Get All cache Keys from all include folders configured in application params
	 * @return [array] [Array of cache keys]
	 */
	public static function getCacheKeys()
	{
		$cacheId = 'app:cache:keys';
		$keys = Yii::$app->cache->get($cacheId);
		if ($keys === false) {
			$files = [];
			foreach (\Yii::$app->params['app.include'] as $where) {
				if (is_dir(Yii::getAlias($where))) {
					$temp = FileHelper::findFiles(Yii::getAlias($where), ['only' => ['cache_keys.php']]);
					if (count($temp) > 0) {
						$files[] = $temp;
					}
				}
			}
			foreach ($files as $file) {
				$keys = ArrayHelper::merge($keys, require($file[0]));
			}
			// We set permanent cache for list of cache keys
			Yii::$app->cache->set($cacheId, $keys, 0);
		}
		return $keys;
	}

	/**
	 * Get All Models from include folder
	 * @return [array] [Array of cache keys]
	 */
	public static function getModels()
	{
		$cacheId = self::getCacheKey('general', 'models');
		$keys = Yii::$app->cache->get($cacheId);
		if ($keys === false) {
			$files = [];
			foreach (\Yii::$app->params['app.include'] as $where) {
				if (is_dir(Yii::getAlias($where))) {
					$temp = FileHelper::findFiles(Yii::getAlias($where), ['only' => ['models.php']]);
					if (count($temp) > 0) {
						$files[] = $temp;
					}
				}
			}
			foreach ($files as $file) {
				$keys = ArrayHelper::merge($keys, require($file[0]));
			}
			// We set permanent cache for list of cache keys
			Yii::$app->cache->set($cacheId, $keys, self::getCacheKeyTimeExpired('general', 'models'));
		}
		return $keys;
	}

	/**
	 * Get detail Model Class and Store key from the list of models
	 * @param  string $id    [Id of the Model]
	 * @param  boolean $type    [Information to get from the Model]
	 * @return mixed Model Info
	 */
	public static function getModel($id = false, $type = false)
	{
		$keys = self::getModels();		
		$result = false;
		if ($id && isset($keys[$id])) {			
			switch ($type) {
				case 'class':
					$result = $keys[$id]['class'];
					break;
				case 'store':
					$result = $keys[$id]['store'];
					break;				
				default:
					$result = $keys[$id];
					break;
			}		
			return $result;	
		}

		if ($result!==false) {
			return $result;	
		} else {
			throw new InvalidConfigException(Yii::t('base', 'Model not found.'));
		}
	}

	/**
	 * Get a cache key from the list of cache keys
	 * @param  string $group [Group of the Cache Key]
	 * @param  string $id    [Id of the Cache Key]
	 * @return [string]         [The Cache Id]
	 */
	public static function getCacheKey($group = false, $id = false)
	{
		$keys = self::getCacheKeys();
		if ($group && $id && isset($keys[$group][$id])) {
			return $keys['prefix'] . $keys[$group][$id][0];
		} else {
			return false;
		}
	}

	/**
	 * Get expired time of a cache key
	 * @param  string $group [Group of the Cache Key]
	 * @param  string $id    [Id of the Cache Key]
	 * @return [integer]         [The Cache Id Expired Time]
	 */
	public static function getCacheKeyTimeExpired($group = false, $id = false)
	{
		$keys = self::getCacheKeys();
		if ($group && $id && isset($keys[$group][$id])) {
			return $keys[$group][$id][1];
		} else {
			return -1;
		}
	}

	/**
	 * Get Menu items from all include folders configured in application params
	 * @param  string $type    [Admin or Site Menu Type]
	 * @return [array] [Array of all menu items based on type]
	 */
	public static function getMenu($type='admin')
	{
		$cacheId = self::getCacheKey('menu', $type);		

		$menu = Yii::$app->cache->get($cacheId);
		if ($menu === false) {
			$files = [];
			foreach (\Yii::$app->params['app.include'] as $where) {
				if (is_dir(Yii::getAlias($where))) {
					$temp = FileHelper::findFiles(Yii::getAlias($where), ['only' => ['menu_'.$type.'.php']]);
					if (count($temp) > 0) {
						$files[] = $temp;
					}
				}
			}
			
			foreach ($files as $file) {
				$menu = ArrayHelper::merge($menu, require($file[0]));
			}

			// Sort Menu items based on its order
			ArrayHelper::multisort($menu, 'order');

			Yii::$app->cache->set($cacheId, $menu, self::getCacheKeyTimeExpired('menu', $type));
		}
		return $menu;
	}

	/**
	 * Get Tenant Object based on the Id. Use cache to store information.
	 * @param  [integer] $id [ID of the Tenant]
	 * @return [mixed]         [Tenant Object]
	 */
	public static function getTenantById($id)
	{		
		$cacheId = self::getCacheKey('tenant', 'tenant_id') . $id;
		$tenant = \Yii::$app->cache->get($cacheId);
		if ($tenant === false) {
			$tenantClass = self::getModel('Tenant', 'class');
			$tenant = $tenantClass::find()->asArray()->where(['id'=>$id])->one();
			if ($tenant) {
				Yii::$app->cache->set($cacheId, $tenant, self::getCacheKeyTimeExpired('teant', 'detail_id'));
			} 
		}
		return $tenant;				
	}


	/**
	 * Generate a unique Tenant Store
	 * @param  [string] $type [Type of Store]
	 * @return [string]         [Store unique key]
	 */
	public static function generateTenantStoreId($type = 'a')
	{		
		return $type.'.'.substr(md5(uniqid()), -3).'.'.substr(md5(microtime()), -3);
	}

	/*
    * Fetch Data from an Array File
    */
    public static function fetchArray($file)
    {
		if (is_file($file)) {
			return include $file;
		}
		return false;
    }

    /*
    * Get all roles by tenant
    */
	public static function getRolesByTenant($tenantId, $tenantStore)
	{
		$cacheId = self::getCacheKey('permission', 'role');
		$roles = Yii::$app->cache->get($cacheId);$roles = false;
		if ($roles == false) {
			$arrCondition = [];
	        if ($tenantStore !== false && $tenantStore != '') {
				$arrCondition = ['store' => $tenantStore];
			}
			$modules = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->all();

			$roles = [];
		    foreach ($modules as $module) {
				$where = '@gxc/yii2' . $module->module . '/permissions/';
				if (is_dir(Yii::getAlias($where))) {
					$permission_files = FileHelper::findFiles(Yii::getAlias($where), ['only' => ['items_admin.php', 'items_site.php']]);
					foreach ($permission_files as $file) {
						$permissions = BaseHelper::fetchArray($file);
		                if (array_key_exists('roles', $permissions)) {
							$roles = array_merge($permissions['roles'], $roles);
						}
					}
				}
			}

			Yii::$app->cache->set($cacheId, $roles, self::getCacheKeyTimeExpired('permission', 'role'));
		}
		return $roles;
	}

	/*
    * Get all roles by tenant
    */
	public static function getPermissionsByTenant($tenantId, $tenantStore)
	{
        $arrCondition = [];
        if ($tenantStore !== false && $tenantStore != '') {
			$arrCondition = ['store' => $tenantStore];
		}
		$modules = \Yii::$app->tenant->createModel('TenantModule')->find()->where($arrCondition)->all();

		$items = [];
	    foreach ($modules as $module) {
			$where = '@gxc/yii2' . $module->module . '/permissions/';
			if (is_dir(Yii::getAlias($where))) {
				$permission_files = FileHelper::findFiles(Yii::getAlias($where), ['only' => ['items_admin.php', 'items_site.php']]);
				foreach ($permission_files as $k => $file) {
					$k = ($k == 0) ? 'admin' : 'site';
					$permissions = BaseHelper::fetchArray($file);
	                if (array_key_exists('items', $permissions)) {
	                	$items[$module->module][$k]['items'] = $permissions['items'];
	                }

	                if (array_key_exists('roles', $permissions)) {
	                	$items[$module->module][$k]['roles'] = $permissions['roles'];
	                }
				}
			}
		}
		return $items;
	}
}