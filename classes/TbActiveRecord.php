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
	/** 
	 * Implement static find function to use the store 
	 * based on the current Tenant Stores
	 */
	public static function find()
	{	

    	/** 
    	 * Currently, we allow Admin to see and manage 
    	 * all models of any tenant. This might be able
    	 * to change by override this class in your application.
    	 * Implement it based on your own business logic needs. 
    	 * 
    	 * Remember to use andWhere() in your own Condition queries
    	 */
		if (!\Yii::$app->tenant->isBackend) {
			return parent::find();
		} else {
			$store = \Yii::$app->tenant->getModel((new \ReflectionClass(self::className()))->getShortName(), 'store');		
			if ($store!==false && $store!='') {
				// Remember to use andWhere() in your own Condition queries
				return parent::find()->where(['store' => \Yii::$app->tenant->current[$store]]);
			} elseif ($store=='') {
				return parent::find();
			} else {
				throw new InvalidConfigException(Yii::t('base', 'Model Not Found'));
			}
		}		
	    
	}

	/** 
	 * Implement to add store value for model
	 * before saving
	 */	
	public function beforeSave($insert)
	{
	    if (parent::beforeSave($insert)) {
	        $store = \Yii::$app->tenant->getModel((new \ReflectionClass(get_class($this)))->getShortName(), 'store');
	        if ($store!==false && $store!='') {
	        	if (!\Yii::$app->tenant->isBackend) {
	        		// If this is the model accessing from Guest Tenant
	        		// Outside of the Backend then we always force
	        		// to use the store from the current tenant
	        		$this->store = \Yii::$app->tenant->current[$store];
	        	} elseif ($this->store=='') {	        		
        			// If the store value is not setted when creating or updateing
        			// a model although the 
        			// model requires it, then, in backend zone, 
        			// the value of the store will be assigned to
        			// root store. Remember this point for later
        			// security checking if needed. Feel free to override this class and method.        		
        			$this->store = \Yii::$app->tenant->root[$store];	        		
	        	}
	        } elseif ($store=='') {
				return true;
			} else {
				throw new InvalidConfigException(Yii::t('base', 'Model Not Found'));
			}
	        return true;
	    } else {
	        return false;
	    }
	}
}