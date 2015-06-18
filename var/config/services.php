<?php

use App\Hooks\PreControllerBase;
use Phalcon\Di\FactoryDefault;
//use Phalcon\Mvc\View;
use Phalcon\Events\Event;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
//use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

//$di = new FactoryDefault();

$config = $di->get('config');


/**
 * set up file logger
 */
$di->set('fileLogger', function() use ($config) {
	return new FileLogger($config->application->logDir . 'app.log');
}, true);


/**
 * @type Phalcon\Logger\Adapter\File\ $oLogger
 */
$oLogger = $di->getFileLogger();

$dispatcherEventsManager = new EventsManager();

$di->set('dispatcher', function() use($dispatcherEventsManager){

	$dispatcher = new MvcDispatcher();
	$dispatcher->setEventsManager($dispatcherEventsManager);
	return $dispatcher;
});



$dispatcherEventsManager->attach("dispatch:beforeExecuteRoute", function(Event $event, MvcDispatcher $dispatcher) use ($di) {

	$oPreController = new PreControllerBase($di);
	$oPreController->handle($event, $dispatcher);
});


$dispatcherEventsManager->attach('dispatch', function($event, $dispatcher) use($oLogger){
//	$oLogger = $di->get('fileLogger');
	$oLogger->debug('common dispatcher: ' . $event->getType());
});

$dispatcherEventsManager->attach('dispatch:beforeException', function(Event $event, MvcDispatcher $dispatcher, $some) use($oLogger){
	$oLogger->debug('common dispatcher: '
		. 'module: "' . $dispatcher->getModuleName() . '";'
		. ' controller: "' . $dispatcher->getControllerClass() . '";'
		. ' action: "' . $dispatcher->getActionName() . '";'
		. ' parameters: ' . print_r($dispatcher->getParams(), true));
//	$oLogger->debug('common dispatcher: ' . $event->getType() . ': ' . print_r($some, true));
});

//$dispatcher->setEventsManager($dispatcherEventsManager);


/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
	$url = new UrlResolver();
	$url->setBaseUri($config->application->baseUri);

	return $url;
}, true);


/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
	return new DbAdapter($config->toArray());
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
	return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
	$session = new SessionAdapter();
	$session->start();

	return $session;
});

$di->set('view', function(){
	$oView = new View();

	return $oView;
});
