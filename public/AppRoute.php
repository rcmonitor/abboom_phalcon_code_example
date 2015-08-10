<?php
use Phalcon\Di;
use Phalcon\Mvc\Router;

/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 30.06.15
 * Time: 18:43
 */
class AppRoute extends Router{


	public function handle($strUrl = null){
		/**
		 * @type \DiCustom $di
		 */
		$di = Di::getDefault();
		$oLogger = $di->getFileLogger();

		$oLogger->debug('handle worked in application for "' . $strUrl . '"');

		parent::handle($strUrl);
	}

}