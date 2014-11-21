<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2app/
 */

namespace gxc\yii2base\assets\app;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Asset bundle for Default Application Layout
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since 2.0
 */
class LayoutAsset extends AssetBundle
{
	
	public function init()
    {
        $this->sourcePath= __DIR__;        
        parent::init();
    }

	public $baseUrl = '@web';

	public $css = [	
		'css/font-awesome.css',
		'css/bootstrap-datetimepicker.min.css',
		'css/screen.css',
	];

	public $js = [					
		'js/moment.js',
		'js/start.js',
	];

	public $depends = [	
		'yii\web\YiiAsset',
		'yii\web\JqueryAsset',			
		'yii\bootstrap\BootstrapPluginAsset',	
	];

	public $jsOptions = [
		'position' => View::POS_END
	];
}
