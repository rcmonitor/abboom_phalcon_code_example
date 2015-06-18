<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 01.06.15
 * Time: 16:49
 */

namespace App\Modules\Api;


use Phalcon\Di;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\DiInterface;
use Phalcon\Mvc\Router\Group;

class ApiRoutes extends Group{


	/**
	 * @var \DiCustom
	 */
	private $di;


//	public function __construct(DiInterface $di){
//		$this->di = $di;
//	}


//	/**
//	 * @var \DiCustom
//	 */
//	protected $_di;
//
//	public function setDi(DiInterface $di){
//		$this->_di = $di;
//	}
//
//
//	public function getDi(){
//		return $this->_di;
//	}

	public function initialize(){
		$this->setPaths(array(
			'module' => 'api'
		));

		$this->setPrefix('/api');

		$this->add('/web/v{major:[0-9]{1,2}}.{minor:[0-9]{1,2}}/:controller/:action/:params', array(
			'controller' => 2,
			'action' => 4,
			'params' => 5,
		));


		$di = Di::getDefault();
		$oLogger = $di->getFileLogger();
//		$oLogger = $this->di->getFileLogger();

		$oLogger->debug(__CLASS__ . '::' . __FUNCTION__ . ': route added');

		$this->beforeMatch(function($uri, $route)
		use ($oLogger)
		{
			$oLogger->debug(__CLASS__ . ': routes: ' . $uri . $route);
		});

	}

}