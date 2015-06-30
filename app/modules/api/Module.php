<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 29.05.15
 * Time: 16:44
 */

namespace App\Modules\Api;


//use App\Modules\Api\ApiRoutes;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
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

//		echo __FUNCTION__ . ' executed <br />' . PHP_EOL;

		$loader = $di->getLoader();
//			new Loader();

//		echo __CLASS__ . ':' . __FUNCTION__ . ' executed after getting loader <br />' . PHP_EOL;

		$loader->registerNamespaces(
			array(
				'App\Modules\Api\Controllers' => __DIR__ . '/controllers/',
				'App\Modules\Api' => __DIR__,
			),
			true
		);

//		echo __CLASS__ . ':' . __FUNCTION__ . ' executed after registering namespaces <br />' . PHP_EOL;

		$oLogger = $di->getFileLogger();
		$oLogger->debug('api loader: namespaces registered: ' . print_r($loader->getNamespaces(), true));

	}

	/**
	 * registering module-specific services
	 *
	 * @param \DiCustom $di
	 */
	public function registerServices(DiInterface $di){

		$oLogger = $di->getFileLogger();

		$oRouter = new Router(false);

		$di->set('router', $oRouter);
		$oRouter->mount(new ApiRoutes($di));

//		$oApiDispatcherEventsManager = new Manager();
////		$oLogger = $di->getFileLogger();
//		$oRouter = $di->getRouter();
//
//		$oLogger->debug('api module ' . __FUNCTION__ . ': setting up dispatcher');
//
//		$oApiDispatcherEventsManager->attach('dispatch', function(Event $event, Dispatcher $dispatcher, $data) use($oLogger, $oRouter){
//			$oLogger->debug('api dispatcher: ' . $event->getType() . ': ' . print_r($oRouter->getMatchedRoute(), true));
//		});
//
//
//		$oDispatcher = $di->getDispatcher();
//		$oDispatcher->setDefaultNamespace('App\Modules\Api\Web');
//		$oDispatcher->setControllerSuffix('Homorrag');
//		$oDispatcher->setEventsManager($oApiDispatcherEventsManager);




		$di->set('dispatcher', function() use($di){
			$dispatcher = new Dispatcher();
			$oApiDispatcherEventsManager = new Manager();
			$oLogger = $di->getFileLogger();
			$oRouter = $di->getRouter();
			$oRequest = $di->getRequest();

			$oLogger->debug('api module ' . __FUNCTION__ . ': setting up dispatcher');

			$oApiDispatcherEventsManager->attach('dispatch', function(Event $event, Dispatcher $dispatcher, $data) use($oLogger, $oRouter, $oRequest){

				if($event->getType() == 'beforeDispatchLoop'){

					$arRoutes = $oRouter->getRoutes();

					foreach ($arRoutes as $oRoute) {
						$oRoute->beforeMatch(function($uri, $route) use ($oLogger){
							$oLogger->debug('__ api module dispatcher route beforeMatch: ' . $uri . $route);

						});
						$oLogger->debug('api module dispatcher: ' . $event->getType() . ': route registered: ' . $oRoute->getCompiledPattern());

						$regPattern = $oRoute->getCompiledPattern();

						$strUri = $oRequest->getURI();

						if(preg_match($regPattern, $strUri)){
							$oLogger->debug('"' . $strUri . '" matched ' . $regPattern);
						}else{
							$oLogger->debug('"' . $strUri . '" mismatched ' . $regPattern);
						}

					}

				}

				$oLogger->debug('api dispatcher: ' . $event->getType() . ': route matched: ' . print_r($oRouter->getMatchedRoute(), true));
				$oLogger->debug('api dispatcher: ' . $event->getType()
					. ' module "' . $oRouter->getModuleName()
					. '" controller: "' . $oRouter->getControllerName()
					. '" action: "' . $oRouter->getActionName() . '"'
				);
			});

			$dispatcher->setEventsManager($oApiDispatcherEventsManager);
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