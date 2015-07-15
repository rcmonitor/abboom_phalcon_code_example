<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 06.07.15
 * Time: 16:51
 */

namespace App\Modules\Api\Web\Controllers;


use Phalcon\Mvc\Controller;

class TestController extends Controller{


	public function testAction(){
		$oLogger = $this->di->getFileLogger();

		$oLogger->debug(__CLASS__ . '::' . __FUNCTION__);
	}

}