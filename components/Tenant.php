<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2base\components;

use Yii;
use yii\base\Component;
use yii\web\NotFoundHttpException;

use gxc\yii2base\helpers\BaseHelper;

/**
 * Tenant component
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since 2.0
 */
class Tenant extends Component
{
	// Info of Current Tenant
	private $_current = null;

	// Info of Root Tenant
	private $_root = null;

	// Is Tenant Component Access from Backend
	private $_isBackend = false;

    // Is Multi Tenants Support
    private $_isMultiTenants = false;

	/**
	 * Initializes this component.
	 */
	public function init()
	{
		parent::init();	
	}

    /**
     * @return mixed the current Tenant Info
     */
    public function getCurrent()
    {
    	return $this->_current;        
    }

    /**
     * @param mixed $value the current Ienant Info
     */
    public function setCurrent($value)
    {
        $this->_current = $value;
    }	   

    /**
     * @return mixed the root Tenant Info
     */
    public function getRoot()
    {
    	return $this->_root;
    }

    /**
     * @param mixed $value the root Ienant Info
     */
    public function setRoot($value)
    {
        $this->_root = $value;
    }

    /**
     * @return boolean the isBackend 
     */
    public function getIsBackend()
    {
    	return $this->_isBackend;
    }

    /**
     * @param boolean $value isBackend 
     */
    public function setIsBackend($value)
    {
        $this->_isBackend = $value;
    }	

    /**
     * @return boolean the isMultiTenants
     */
    public function getIsMultiTenants()
    {
        return $this->_isMultiTenants;
    }

    /**
     * @param boolean $value isMultiTenants
     */
    public function setIsMultiTenants($value)
    {
        $this->_isMultiTenants = $value;
    }   	

    /**
     * Get detail Model Class and Store key from the list of models
     * @param  string $id    [Id of the Model]
     * @param  boolean $type    [Information to get from the Model]
     * @return mixed Model Info
     */
    public function getModel($id, $type = false)
    {
        return BaseHelper::getModel($id, $type);
    }

}