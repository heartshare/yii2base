<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2app/
 */

namespace gxc\yii2base\classes;

use Yii;

/**
 * Base Module for other Modules to inherit
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since 2.0
 */
class Module extends \yii\base\Module
{

	public $version = '1.0.0-dev';

	public $dbConnection = 'db';

	public $id = 'yii2module';

	public $name = 'Yii2 Module';

	/**
     * @inheritdoc
     */
	public function init()
	{		
		parent::init();				
	}	
}
