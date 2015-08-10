<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 07.07.15
 * Time: 15:46
 */

use Phalcon\Di;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Version;


$di = new Di\FactoryDefault();

$oRouter = new Router(false);
$oRouter->setDI($di);

$oRouter->add('/:controller', array(
	'controller' => 1,
	'action' => 'index',
));


$oEventManager = new Manager();
$oEventManager->attach('dispatch:beforeDispatch', function(){
	return false;
});

$oDispatcher = new Dispatcher();

$oDispatcher->setDI($di);

$oDispatcher->setEventsManager($oEventManager);

$oRouter->handle('/test');

$oDispatcher->setControllerName($oRouter->getControllerName());
$oDispatcher->setActionName($oRouter->getActionName());

$oDispatcher->dispatch();

echo $oDispatcher->getControllerClass() . PHP_EOL;

echo Version::get() . PHP_EOL;