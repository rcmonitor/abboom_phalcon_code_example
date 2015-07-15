<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 30.06.15
 * Time: 18:20
 */

namespace App\Modules\Api;


use Phalcon\Di;
use Phalcon\Mvc\Router;

class CustomRouter extends Router{


	public function handle($strUrl = null){

		/**
		 * @type \DiCustom $di
		 */
		$di = Di::getDefault();
		$oLogger = $di->getFileLogger();

		$oLogger->debug('handle worked in api module for "' . $strUrl . '"');

		parent::handle($strUrl);
	}
}