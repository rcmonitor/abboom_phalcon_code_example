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
use Phalcon\Mvc\Router\Route;

class ApiRoutes extends Group{


	/**
	 * @var \DiCustom
	 */
	private $di;



	public function initialize(){
		$this->setPaths(array(
			'module' => 'api',
			'namespace' => 'App\Modules\Api'
		));

		$this->setPrefix('/api');

		$this->add('/{media}/v{major:[0-9]{1,2}}\.{minor:[0-9]{1,2}}/:controller/:action/:int', array(
			'controller' => 4,
			'action' => 5,
			'id' => 6
		))->setName('media_syntax_version_action_controller_id');


		$di = Di::getDefault();

		$oLogger = $di->getFileLogger();

		$oLogger->debug(__CLASS__ . '::' . __FUNCTION__ . ': route added');

		$this->beforeMatch(function($uri, $route) use ($oLogger) {

			/**
			 * @type Route $route
			 */
			$oLogger->debug(__CLASS__ . ': before match: routes: ' . $uri . ': ' . $route->getName() . ': ' . $route->getPattern());

			return true;
		});

	}

}