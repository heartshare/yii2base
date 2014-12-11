<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2base/
 */

namespace gxc\yii2base;

use Yii;

/**
 * Module of Base Application
 * 
 * This module takes care of all base components like user, tenant, setting
 * 
 * This module is required as a foundation for other module, developed by GXC to work
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since 2.0
 */
class Module extends \gxc\yii2base\classes\Module
{

	public $version = '1.0.0-dev';

	public $permissionId = 'yii2base';

	public $name = 'Base Application Module';
	
	public function init()
	{				
		parent::init();

		// set up i8n
        if (empty(\Yii::$app->i18n->translations['base'])) {
            \Yii::$app->i18n->translations['base'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',                
            ];
        }					
	}
}
