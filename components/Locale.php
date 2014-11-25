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
 * Locale component. This component is used to 
 * convert time between current timezone to default timezone UTC and vice versa.
 * It also holds some information about the 
 * 
 * \Yii::$app->locale->toLocalTime(null, null, 'Y-m-d H:i:s');
 * \Yii::$app->locale->toUTCTime(null, null, 'Y-m-d H:i:s');
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since 2.0
 */
class Locale extends Component
{
	/**
	 * Default TimeZone of the Application. This information is
	 * assigned from the first application behaviors.
	 * @var string
	 */
	public $defaultTimezone='UTC';

	/**
	 * 
	 * Current timezone of the application based on application 
	 * setting or user Setting or user Session.
	 *
	 * To implement the logic code of local Timezone, please
	 * implement it as the application behaviors like BackendConfigBehavior
	 * or FrontendConfigBehavior
	 * @var string
	 */
	public $localTimezone;

	/**
	 * Convert a timestamp to UTC and return with or without date format
	 * @param  mixed  $value  The timestamp that we need to convert to
	 * @param  mixed $formatInput Format of the input timestamp
	 * @param  mixed $formatOutput If format is added, the result will return with DateTime Format
	 * @return mixed          The time return from the input
	 */
	public function toUTCTime($value = null, $formatInput = null, $formatOutput = false)
	{
		$result = false;
		if ($formatInput===null) {
			$formatInput = 'Y-m-d H:i:s';
		}
		if ($value &&  is_numeric($value)) {
			$result = new \DateTime($value, new \DateTimeZone($this->localTimezone));			
		} elseif (is_string($value)) {
			// So we have a string 
			// The string means that this is a date time in string format
			// and it is from Local TimeZone
			$result = \DateTime::createFromFormat($formatInput, $value);									
		} elseif ($value===null) {
			$result = new \DateTime(null, new \DateTimeZone($this->localTimezone));						
		}	
		if ($result) {
			$result->setTimeZone(new \DateTimeZone('UTC'));				
		}
		return ($formatOutput) ? $result->format($formatOutput) : $result;		
	}

	/**
	 * Convert a timestamp from UTC to Local Time and return with or without date format
	 * @param  mixed $value  The timestamp that we need to convert to
	 * @param  mixed $formatInput Format of the input timestamp
	 * @param  mixed $formatOutput If format is added, the result will return with DateTime Format
	 * @return mixed          The time return from the input
	 */
	public function toLocalTime($value = null, $formatInput = null, $formatOutput = false)
	{
		$result = false;
		if ($formatInput===null) {
			$formatInput = 'Y-m-d H:i:s';
		}
		if ($value &&  is_numeric($value)) {
			$result = new \DateTime($value, new \DateTimeZone('UTC'));						
		} elseif (is_string($value)) {
			$result = \DateTime::createFromFormat($formatInput, $value);									
		} elseif ($value===null) {
			$result = new \DateTime(null, new \DateTimeZone('UTC'));						
		}	
		if ($result) {			
			$result = new \DateTime($value, new \DateTimeZone($this->localTimezone));
		}
		return ($formatOutput) ? $result->format($formatOutput) : $result;			
	}
}