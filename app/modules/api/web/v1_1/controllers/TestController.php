<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 20.07.15
 * Time: 17:43
 */

namespace App\Modules\Api\Web\Controllers;


use Phalcon\Mvc\Controller;

class TestController extends Controller{


	public function indexAction(){

		return 'some string';

	}

}