<?php

use App\Hooks\ModuleRouter;
use Phalcon\Events\Manager;
use Phalcon\Http\Request;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;

error_reporting(E_ALL);

try {

	/**
	 * Read common configuration
	 */
	$config = include __DIR__ . "/../var/config/config.php";

	/**
	 * Read common auto-loader
	 */
	include __DIR__ . "/../var/config/loader.php";

	/**
	 * Read common services
	 */
	include __DIR__ . "/../var/config/services.php";

	$oLogger = $di->getFileLogger();

	$strVendorLoaderPath = $config->application->libraryDir . '/autoload.php';
	require_once $strVendorLoaderPath;




//	$di->set('router', function(){
//		$oRouter = new Router();
//
////		$oRouter->setEventsManager($oRouterEventsManager);
//
//
//		$oRouter->add("/regular", array(
//			'module'     => 'regular',
//			'controller' => 'index',
//			'action'     => 'index',
//			'namespace' => 'App\Modules\Regular\Controllers'
//		));
//
//
//		$oRouter->add('/api', array(
//			'module' => 'api',
//			'controller' => 'index',
//			'action' => 'index',
//			'namespace' => 'App\Modules\Api\Controllers',
//		));
//
//
////	route requests to corresponding modules
////		$oRouter->add('/api/.*', array(
////			'module' => 'Api'
////		));
////		$oRouter->add('/regular/.*', array(
////			'module' => 'Regular'
////		));
//
//		return $oRouter;
//	});

//	$strMsg = 'base routes added; creating application';

//	Kint::dump($strMsg);

//	$di->getFileLogger()->debug(@s($strMsg));

//	$di->set('router', function () {
//		$router = new Router();
//
//		$router->setDefaultModule("regular");
//
////		$router->add("/", array(
////			'module'     => 'regular',
////			'controller' => 'index',
////			'action'     => 'index',
////		));
////
////
////		$router->add('/api', array(
////			'module' => 'api',
////			'controller' => 'index',
////			'action' => 'index',
////		));
//
////		$router->add("/admin/products/:action", array(
////			'module'     => 'backend',
////			'controller' => 'products',
////			'action'     => 1,
////		));
////
////		$router->add("/products/:action", array(
////			'controller' => 'products',
////			'action'     => 1,
////		));
//
//		return $router;
//	}, true);

	$oAppEventsManager = new Manager();



//	$di->set('application', function() use($di, $oAppEventsManager){
//		$oApplication = new Application($di);
//		$oApplication->setEventsManager($oAppEventsManager);
//	});


	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application($di);

	$application->setEventsManager($oAppEventsManager);

	$oAppEventsManager->attach('application', function($event, $application) use ($oLogger){
		$oLogger->debug('application: ' . $event->getType());
	});



	$oAppEventsManager->attach('application:boot', function($event, $application, $exception){

		$oDi = $application->getDi();

		$oLogger = $oDi->getFileLogger();

//		$oLogger->debug('application:boot: ' . $event->getType() . ' router: ' . print_r($oDi->getRouter()->getRoutes(), true));

//		$oPreRouter = new Router();
//
////		$oPreRouter->setDefaultModule('regular');
//
//		$oPreRouter->add('/api(.*)', array(
//			'module' => 'api',
//		));
//		$oPreRouter->add('/regular(.*)', array(
//			'module' => 'regular'
//		));
//		$oPreRouter->add('/blind(.*)', array(
//			'module' => 'blind',
//		));
//
//		$oPreRouter->handle();
//
//		$arKnownModules = array(
//			'regular' => array(
//				'className' => 'App\Modules\Regular\Module',
//				'path' => '../app/modules/regular/Module.php',
//			),
//			'api' => array(
//				'className' => 'App\Modules\Api\Module',
//				'path' => '../app/modules/api/Module.php',
//			),
//			'blind' => array(
//				'className' => 'App\Modules\Blind\Module',
//				'path' => '../app/modules/blind/Module.php',
//			),
//		);
//
//		$strSelectedModule = $oPreRouter->getModuleName();
//
//		$application->registerModules(array(
//			$strSelectedModule => $arKnownModules[$strSelectedModule],
//		));
//



		/**
		 * @type Request $oRequest
		 */
//		$oRequest = $oDi->getRequest();
//		$oLogger->debug('application:boot: ' . $event->getType() . ' request: ' . $oRequest->getURI() . ' leads to module: ' . $strSelectedModule);
	});


	$oLoader = $di->getLoader();
	$oLogger->debug('index: ' . print_r($oLoader->getNamespaces(), true));

	/**
	 *
	 */
	$oModuleRouter = new ModuleRouter($application);

	if($oModuleRouter->handle()){
		echo $application->handle()->getContent();
	}else{
//		running old application

	}

//	$application->registerModules(array(
//		'regular' => array(
//			'className' => 'Modules\Regular\Module',
//			'path' => '../app/modules/regular/Module.php',
//		),
//		'api' => array(
//			'className' => 'Modules\Api\Module',
//			'path' => '../app/modules/api/Module.php',
//		),
//		'blind' => array(
//			'className' => 'Modules\Blind\Module',
//			'path' => '../app/modules/blind/Module.php',
//		),
//	));

//	$application = $di->application;


} catch (\Exception $e) {
	echo '<h3>' . $e->getMessage() . '</h3>';

	echo '<h2>' . $e->getLine() . ': ' . $e->getFile() . '</h2>';

	$arTrace = $e->getTrace();



	foreach ($arTrace as $offset => $line) {
		echo '<p><b>' . $offset . ':</b> ' . print_r($line, true) . '</p>';
	}

}


