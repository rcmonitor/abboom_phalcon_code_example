<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 15.06.15
 * Time: 15:50
 */

namespace App\Util;


use Phalcon\Config;
use Phalcon\Di;

class U{


	/**
	 * @return \DiCustom
	 */
	public static function getDi(){
		return Di::getDefault();
	}


	/**
	 * @return Config
	 */
	public static function getConfig(){
		return self::getDi()->getConfig();
	}


	/**
	 * @return boolean true if app is using legacy code from old version of abboom;
	 * 					false otherwise
	 */
	public static function isLegacy(){
		return self::getConfig()->environment->legacy;
	}


	/**
	 * @return boolean true if application is in development mode;
	 * 					false if application is in production mode;
	 */
	public static function isDev(){
		return self::getConfig()->environment->development;
	}
}