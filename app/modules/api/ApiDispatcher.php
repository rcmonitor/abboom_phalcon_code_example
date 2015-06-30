<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 19.06.15
 * Time: 14:15
 */

namespace App\Modules\Api;


use Phalcon\Mvc\Dispatcher;

class ApiDispatcher extends Dispatcher{


	public function __construct(){
		$this->setControllerSuffix('Gomorrah');
	}
}