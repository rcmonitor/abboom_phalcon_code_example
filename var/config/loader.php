<?php

use Phalcon\Events\Manager;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;


$oEventsManager = new Manager();
//$loader = new \Phalcon\Loader();

$di->setShared('loader', function() use ($oEventsManager, $di){
	$oLoader = new Loader();

	$oConfig = $di->getConfig();

	$oLoader->setEventsManager($oEventsManager);
	$oLoader->registerNamespaces(array(
		'App\Modules' => $oConfig->application->modulesDir,
		'App\Hooks' => $oConfig->application->hooksDir,
		'App\Util' => $oConfig->application->utilDir,
		'App\Core\Interfaces' => $oConfig->application->ifaceDir,
		'App\Modules\Api' => __DIR__ . '/../../app/modules/api',
	));

	$oLogger = $di->getFileLogger();

//	$oLogger->debug('namespaces registered in main loader');

//	foreach ($oConfig->modules as $strNamespace => $strDirectory) {
//
//		$arNamespace = array(
//			'App\Modules\\' . $strNamespace => $oConfig->application->modulesDir . '/' . $strDirectory
//		);
//
//		$oLogger->debug('trying to register namespaces: ' . print_r($arNamespace, true));
//
//		$oLoader->registerNamespaces($arNamespace);
//	}


//	$oLogger = $di->getFileLogger();
	$oLogger->debug('config already read; common loader initialization; here`s the beginning for "'
		. $di->getRequest()->getURI() . '"'
		. str_repeat('_', 170) . PHP_EOL
		. print_r($oLoader->getNamespaces(), true));

	$oLoader->register();

	return $oLoader;
});



//$oEventsManager->attach('loader', function($event, $loader, $strClassName) use ($di) {
//
//	$oLogger = $di->getFileLogger();
//	$oLogger->debug('common loader: ' . $event->getType() . ': trying "' . $loader->getCheckedPath() . '" parameter is "' . $strClassName . '"');
//});

