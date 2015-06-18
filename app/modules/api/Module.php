<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 29.05.15
 * Time: 16:44
 */

namespace App\Modules\Api;


use App\Modules\Api\ApiRoutes;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Http\Request;
use Phalcon\Loader,
	Phalcon\Mvc\Dispatcher,
	Phalcon\Mvc\View,
	Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Logger\Adapter\File;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Module implements ModuleDefinitionInterface {


//	private $viewsDir = __DIR__ . '/../views';


//	private $cacheDir = __DIR__ . '/'

	/**
	 * @param \DiCustom $di
	 */
	public function registerAutoloaders(DiInterface $di = null)
	{

		echo __FUNCTION__ . ' executed <br />' . PHP_EOL;

		$loader = $di->getLoader();
//			new Loader();

		echo __CLASS__ . ':' . __FUNCTION__ . 'executed after getting loader <br />' . PHP_EOL;

		$loader->registerNamespaces(
			array(
				'App\Modules\Api\Controllers' => __DIR__ . '/controllers/',
				'App\Modules\Api' => __DIR__,
			),
			true
		);

		echo __CLASS__ . ':' . __FUNCTION__ . 'executed after registering namespaces <br />' . PHP_EOL;

		$oLogger = $di->getFileLogger();
		$oLogger->debug('api loader: namespaces registered: ' . print_r($loader->getNamespaces(), true));

//		$loader->register();
	}

	/**
	 * registering module-specific services
	 *
	 * @param \DiCustom $di
	 */
	public function registerServices(DiInterface $di)
	{

		echo __FUNCTION__ . ' executed <br />' . PHP_EOL;

		/**
		 * @type $oRequest Request
		 */
		$oRequest = $di->getRequest();

//		/**
//		 * @type $oRouter Router
//		 */
//		$oRouter = $di->getRouter();

		/**
		 * @type File $oLogger
		 */
		$oLogger = $di->getFileLogger();

//		$oRouter->add()

//		$oApiRoutes = new ApiRoutes();
		$oRouter = new Router();
		$di->set('router', $oRouter);
		$oRouter->mount(new ApiRoutes($di));


		// Регистрация диспетчера
		$di->set('dispatcher', function() {
			$dispatcher = new Dispatcher();
			$dispatcher->setDefaultNamespace('App\Modules\Api\Web');
			return $dispatcher;
		});


//		$oConfig = new Config(array(
//			'application' => array(
//				'viewsDir' => __DIR__ . '/views',
//				'cacheDir' => __DIR__ . '/../../../var/cache/regular'
//			),
//		));
//
//		$di->get('config')->merge($oConfig);


		/**
		 * Setting up the view component
		 */
		$di->set('view', function() use($oLogger){

			$oView = new View();

			$oView->setRenderLevel(View::LEVEL_NO_RENDER);

			$oView->disable();

			$oLogger->debug('view: render level set to disabled');

			//Disable several levels
//			$view->disableLevel(array(
//				View::LEVEL_LAYOUT      => true,
//				View::LEVEL_MAIN_LAYOUT => true
//			));

			return $oView;

		}, true);
	}

}