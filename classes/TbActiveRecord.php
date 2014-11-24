<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */
namespace gxc\yii2base\classes;

use yii\base\InvalidConfigException;

/**
 * Tenant Based Active Record, which retrieves and updates data
 * based on Tenant Stores
 * 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class TbActiveRecord extends \yii\db\ActiveRecord
{
	// Implement static find function to use the store 
	// based on the current Tenant Stores
	public static function find()
	{	
	
    	// Currently, we allow Admin to see and manage 
    	// all contents of guest tenant. This might be able
    	// to change and it depends on the application business logic.
		if (!\Yii::$app->tenant->isBackend) {
			return parent::find();
		} else {
			$store = \Yii::$app->tenant->getModel((new \ReflectionClass(self::className()))->getShortName(), 'store');		
			if ($store!==false && $store!='') {
				return parent::find()->where(['store' => \Yii::$app->tenant->current[$store]]);
			} elseif ($store=='') {
				
			} else {
				throw new InvalidConfigException(Yii::t('base', 'Model Not Found'));
			}
		}		
	    
	}
}