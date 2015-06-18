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




	$oAppEventsManager = new Manager();



	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application($di);

//	echo 'application created <br />';
//
//	$di->setShared('application', $application);
//
//	echo 'added to di container <br />';

	$application->setEventsManager($oAppEventsManager);

	$oAppEventsManager->attach('application', function($event, $application) use ($oLogger){
		$oLogger->debug('application: ' . $event->getType());
	});

//	echo 'event manager attached <br />';

	$arNamespaces = $di->getLoader()->getNamespaces();
//	var_dump($arNamespaces);

	$oModuleRouter = new ModuleRouter($application);

//	$di->set('moduleRouter', $oModuleRouter);

	if($oModuleRouter->handle()){
		echo $application->handle()->getContent();
	}else{
//		running old application

	}

} catch (\Exception $e) {
	echo '<h3>' . $e->getMessage() . '</h3>';

	echo '<h2>' . $e->getLine() . ': ' . $e->getFile() . '</h2>';

	$arTrace = $e->getTrace();



	foreach ($arTrace as $offset => $line) {
		echo '<p><b>' . $offset . ':</b> ' . print_r($line, true) . '</p>';
	}

}


