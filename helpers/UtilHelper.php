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

/**
 * Util Helper Class 
 * @author  Tuan Nguyen <nganhtuan63@gmail.com>
 * @since  2.0
 */
class UtilHelper
{   
	
	/**
	 * Create GUID 
	 * @return [string] [GUID String]
	 */
	public static function createGUID()
	{
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);
		$uuid = substr($charid, 0, 8).$hyphen.substr($charid, 8, 4).$hyphen.substr($charid,12, 4).$hyphen.substr($charid,16, 4).$hyphen.substr($charid,20,12);
		return $uuid;
	}

	/** 
	 * Create and Return Alpha ID
	 * @author  Kevin van Zonneveld &lt;kevin@vanzonneveld.net>
	 * @author  Simon Franz
	 * @author  Deadfish
	 * @author  SK83RJOSH
	 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
	 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
	 * @link    http://kevin.vanzonneveld.net/
	 *
	 * @param mixed   $in   String or long input to translate
	 * @param boolean $to_num  Reverses translation when true
	 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
	 * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
	 *
	 * @return mixed string or long
	 */
	function alphaID($in, $to_num = false, $pad_up = false, $pass_key = null)
	{
	  $out   =   '';

	  //Remove a,e,i,o,u characters to prevent bad words
	  $index = 'bcdfghjklmnpqrstvwxyz0123456789BCDFGHJKLMNPQRSTVWXYZ=_-';
	  $base  = strlen($index);

	  if ($pass_key !== null) {

	    // Although this function's purpose is to just make the
	    // ID short - and not so much secure,
	    // with this patch by Simon Franz (http://blog.snaky.org/)
	    // you can optionally supply a password to make it harder
	    // to calculate the corresponding numeric ID

	    for ($n = 0; $n < strlen($index); $n++) {
	      $i[] = substr($index, $n, 1);
	    }

	    $pass_hash = hash('sha256',$pass_key);
	    $pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

	    for ($n = 0; $n < strlen($index); $n++) {
	      $p[] =  substr($pass_hash, $n, 1);
	    }

	    array_multisort($p, SORT_DESC, $i);
	    $index = implode($i);
	  }

	  if ($to_num) {
	    // Digital number  <<--  alphabet letter code
	    $len = strlen($in) - 1;

	    for ($t = $len; $t >= 0; $t--) {
	      $bcp = bcpow($base, $len - $t);
	      $out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
	    }

	    if (is_numeric($pad_up)) {
	      $pad_up--;

	      if ($pad_up > 0) {
	        $out -= pow($base, $pad_up);
	      }
	    }
	  } else {
	    // Digital number  -->>  alphabet letter code
	    if (is_numeric($pad_up)) {
	      $pad_up--;

	      if ($pad_up > 0) {
	        $in += pow($base, $pad_up);
	      }
	    }

	    for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
	      $bcp = bcpow($base, $t);
	      $a   = floor($in / $bcp) % $base;
	      $out = $out . substr($index, $a, 1);
	      $in  = $in - ($a * $bcp);
	    }
	  }

	  return $out;
	}

	/**
	 * Convert a String to Time based on format
	 * @param  [string] $str    [String of the Date Time]
	 * @param  [string] $format [Format of the Date Time]
	 * @return [integer]         [Timestamp after convert]
	 */
	public static function stringToTime($str, $format)
	{
		$time = date_parse_from_format($format, $str);
		if ($time) {
			return mktime(
				$time['hour'], 
        		$time['minute'], 
        		$time['second'], 
        		$time['month'], 
        		$time['day'], 
        		$time['year']
        	);
		} 
		return false;
	}	

    /**
     * Strip Unicode Character 
     * @param  [string] $str [Special unicode strings]
     * @return [string]      [String after strip unicode characters]
     */
    public static function stripUnicodeToUrl($str)
	{
		 $unicode = [
			'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
			'd'=>'đ',
			'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
			'i'=>'í|ì|ỉ|ĩ|ị',
			'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
			'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
			'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
				    'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
			'D'=>'Đ',
			'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
			'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
			'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
			'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
			'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
		    ];
        
		foreach($unicode as $nonUnicode=>$uni){
		     $str = preg_replace("/($uni)/i", $nonUnicode, $str);
		}
		
		$str=str_replace(' ','-',trim($str));
		return $str;
	}

	/**
	 * Convert a string to array based on comma
	 * @param  [string] $str [String to convert]
	 * @return [array]      [Array after converted]
	 */
	public static function stringToArray($str)
	{
		return array_unique(preg_split('/\s*,\s*/u', preg_replace('/\s+/u', ' ', trim($str)), -1, PREG_SPLIT_NO_EMPTY));		
	}

	/**
	 * Convert an array to String
	 * @param  [array] $arr [Array to Convert]
	 * @return [string]      [String after converted]
	 */
	public static function arrayToString($arr)
	{
		return implode(', ', $arr);
	}
}