<?php
use Phalcon\Mvc\Dispatcher;

/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 19.06.15
 * Time: 14:16
 */
class CommonDispatcher extends Dispatcher{


	public function __construct(){
		$this->setControllerSuffix('Sodom');
	}

}