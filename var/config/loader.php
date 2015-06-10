<?php

use Phalcon\Events\Manager;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;


$oEventsManager = new Manager();
$loader = new \Phalcon\Loader();

$di->set('loader', function() use ($oEventsManager, $di){
	$oLoader = new Loader();

	$oConfig = $di->getConfig();

	echo 'attaching events manager <br />' . PHP_EOL;

	$oLoader->setEventsManager($oEventsManager);
	$oLoader->registerNamespaces(array(
		'App\Modules' => $oConfig->application->modulesDir,
		'App\Hooks' => $oConfig->application->hooksDir,

	));

	$oLogger = $di->getFileLogger();
	$oLogger->debug('common loader initialization: ' . print_r($oLoader->getNamespaces(), true));

	$oLoader->register();

	return $oLoader;
});



$oEventsManager->attach('loader', function($event, $loader, $strClassName) use ($di) {


	/**
	 * @type $oLogger Phalcon\Logger\Adapter\File
	 */
	$oLogger = $di->getFileLogger();

	/**
	 * @type $oRequest Phalcon\Http\Request
	 */
	$oRequest = $di->getRequest();
//	$arContext = array(
//		'requested' => $oRequest->getURI(),
//		'type' => $oRequest->getMethod(),
//	);
//
//	$arTestContext = array('first string', 'moar string');
//	$arSecondTestContext = array(
//		'first offset' => 'first value',
//		'second offset' => 'second value',
//	);

//	$strClassMsg = 'common loader: ';

	/**
	 * @type \Phalcon\Events\Event $event
	 * @type \Phalcon\Loader $loader
	 */

//	/**
//	 * @type Dispatcher $oDispatcher
//	 */
//	$oDispatcher = $di->getDispatcher();
//	$oDispatcher->

	$oLogger->debug('common loader: ' . $event->getType() . ': trying "' . $loader->getCheckedPath() . '" parameter is "' . $strClassName . '"');


//	if ($event->getType() == 'beforeCheckPath') {
//		$strMsg = $strClassMsg . 'requested ' . $oRequest->getMethod() . ' from ' . $oRequest->getURI();
//		$strMsg .= ' trying: ' . $loader->getCheckedPath();
//		echo $strMsg . '<br />';
//		$oLogger->debug($strMsg, $arTestContext);
//	}elseif($event->getType() == 'pathFound'){
//		$strMsg = $strClassMsg . 'gotcha: ' . $loader->getCheckedPath();
//		echo $strMsg . '<br />';
//		$oLogger->debug($strMsg, $arContext);
//	}elseif($event->getType() == 'afterCheckPath'){
//		$strMsg = $strClassMsg . 'not found: ' . $loader->getCheckedPath();
////		echo $strMsg . '<br />';
//		$oLogger->debug($strMsg, $arSecondTestContext);
//	}

});


/**
 * commented till here
 */



//$loader->setEventsManager($eventsManager);




//$loader->registerNamespaces(array(
//	'Modules' => __DIR__ . '/../../app/modules',
//));
//
///**
// * We're a registering a set of directories taken from the configuration file
// */
//$loader->registerDirs(
//	array(
////		$config->application->modulesDir,
////		$config->application->controllersDir,
////		$config->application->modelsDir,
////		$config->application->preControllersDir,
//	)
//)->register();
