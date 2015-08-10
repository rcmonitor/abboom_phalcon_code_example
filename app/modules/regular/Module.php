<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 29.05.15
 * Time: 16:44
 */

namespace App\Modules\Regular;


use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Loader,
	Phalcon\Mvc\Dispatcher,
	Phalcon\Mvc\View,
	Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Logger\Adapter\File;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Module implements ModuleDefinitionInterface {


//	private $viewsDir = __DIR__ . '/../views';


//	private $cacheDir = __DIR__ . '/'

	/**
	 * @param DiInterface $di
	 */
	public function registerAutoloaders(DiInterface $di = null)
	{

		echo __FUNCTION__ . ' executed <br />' . PHP_EOL;


		/**
		 * @type File $oLogger
		 */
		$oLogger = $di->getFileLogger();

//		$oLoaderEventsManager = new Manager();


//		$di->set('appLoader', function() use($oLoaderEventsManager){
//			$oLoader = new Loader();
//
//			$oLoader->setEventsManager($oLoaderEventsManager);
//
//			$oLoader->registerNamespaces(
//				array(
//					'App\Modules\Regular\Controllers' => __DIR__ . '/controllers/',
////				'Regular\Models'      => '../apps/backend/models/',
//				)
//			);
//
//			$oLoader->register();
//
//			return $oLoader;
//		});



		/**
		 * @type Loader $oLoader
		 */
		$oLoader = $di->get('loader');
//			new Loader();


		$oLoader->registerNamespaces(
			array(
				'App\Modules\Regular\Controllers' => __DIR__ . '/controllers/',
//				'Regular\Models'      => '../apps/backend/models/',
			),
			true
		);

		$oLogger->debug('regular loader initialization: ' . print_r($oLoader->getNamespaces(), true));

		$oLoaderEventsManager = $oLoader->getEventsManager();

		$oLoaderEventsManager->attach('loader', function(Event $event, Loader $loader, $strClassName) use($oLogger){
			$oLogger->debug('regular loader: ' . $event->getType() . ': ' . $strClassName . ' tried ' . $loader->getCheckedPath());

		});

//		$oLoader->register();
	}

	/**
	 * registering specific module services
	 */
	public function registerServices(DiInterface $di)
	{

		$di->set('view', function(){
			$oView = new View();

			return $oView;
		});


		$oLogger = $di->getFileLogger();

		echo __FUNCTION__ . ' executed <br />' . PHP_EOL;

//		$oDispatcherEventsManager = new Manager();

		/**
		 * @type Dispatcher $oDispatcher
		 */
		$oDispatcher = $di->getDispatcher();

		$oDispatcherEventsManager = $oDispatcher->getEventsManager();
		$oDispatcher->setDefaultNamespace('App\Modules\Regular\Controllers');

//		// Регистрация диспетчера
//		$di->set('dispatcher', function() use($oDispatcherEventsManager) {
//			$dispatcher = new Dispatcher();
//			$dispatcher->setEventsManager($oDispatcherEventsManager);
//			$dispatcher->setDefaultNamespace('App\Modules\Regular\Controllers');
//			return $dispatcher;
//		});

		$oDispatcherEventsManager->attach('dispatch', function($event, $dispatcher, $exception) use ($oLogger){
			$oLogger->debug('module dispatcher: ' . $event->getType() . ': ' . $exception);
		});
//
//
//
//
//		$oConfig = new Config(array(
//			'application' => array(
//				'viewsDir' => __DIR__ . '/views',
//				'cacheDir' => __DIR__ . '/../../../var/cache/regular'
//			),
//		));
//
//		$di->get('config')->merge($oConfig);
//
//
//		/**
//		 * Setting up the view component
//		 */
//		$di->set('view', function () use ($di) {
//
//			$view = new View();
//			$oConfig = $di->getConfig();
//
//			$view->setViewsDir($oConfig->application->viewsDir);
//
////			$view->registerEngines(array(
////				'.volt' => function ($view, $di) use ($oConfig) {
////
////					$volt = new VoltEngine($view, $di);
////
////					$volt->setOptions(array(
////						'compiledPath' => $oConfig->application->cacheDir,
////						'compiledSeparator' => '_'
////					));
////
////					return $volt;
////				},
////				'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
////			));
//
//			return $view;
//		}, true);
//
////
////		// Регистрация компонента представлений
////		$di->set('view', function() {
////			$view = new View();
////			$view->setViewsDir('../apps/backend/views/');
////			return $view;
////		});
	}

}