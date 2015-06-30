<?php

require __DIR__ . '/../var/config/DiCustom.php';

use App\Hooks\ModuleRouter;
use Phalcon\Debug;
use Phalcon\Di;
use Phalcon\Events\Manager;
use Phalcon\Http\Request;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;

error_reporting(E_ALL);

try {
	$di = new DiCustom();

	Di::setDefault($di);

	/**
	 * Read common configuration
	 */
	$oConfig = include __DIR__ . "/../var/config/config.php";

	$di->setShared('config', $oConfig);

	/**
	 * Read common auto-loader
	 */
	include __DIR__ . "/../var/config/loader.php";

	/**
	 * Read common services
	 */
	include __DIR__ . "/../var/config/services.php";

	$oLogger = $di->getFileLogger();

	$strVendorLoaderPath = $oConfig->application->libraryDir . '/autoload.php';
	require_once $strVendorLoaderPath;

	$oAppEventsManager = new Manager();

	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application($di);

	$application->setEventsManager($oAppEventsManager);

	$oAppEventsManager->attach('application', function($event, $application) use ($oLogger){
		$oLogger->debug('application: ' . $event->getType());
	});

	$arNamespaces = $di->getLoader()->getNamespaces();

	/**
	 * here's all the magic with modules
	 */
	$oModuleRouter = new ModuleRouter($application);

	if($oModuleRouter->handle()){

		$oLogger->debug('app modules registered: ' . print_r($application->getModules(), true));
		$oLogger->debug('app default module: "' . $application->getDefaultModule() . '"');

		echo $application->handle()->getContent();
	}else{
//		running old application
		require_once __DIR__ . '/../legacy/public/index.php';
	}

} catch (\Exception $e) {
	echo '<h3>' . $e->getMessage() . '</h3>';

	echo '<h2>' . $e->getLine() . ': ' . $e->getFile() . '</h2>';

	$arTrace = $e->getTrace();



	foreach ($arTrace as $offset => $line) {
		echo '<p><b>' . $offset . ':</b> ' . print_r($line, true) . '</p>';
	}

	$oLogger->error($e->getLine() . ':' . $e->getFile() . ':' . get_class($e) . ' "' . $e->getMessage() . '"');
}


