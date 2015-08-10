<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 30.06.15
 * Time: 19:10
 */

use App\Modules\Api\ApiRoutes;
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\Router;

$di = Di::getDefault();

$oLogger = $di->getFileLogger();
$oLogger->debug('initializing route');

/**
 * @type Loader
 */
$oLoader = $di->getLoader();
$arClasses = $oLoader->getClasses();

$oLogger->debug(print_r($arClasses, true));

$oRouter = new Router();

$oApiRoutes = new ApiRoutes();
$oRouter->mount($oApiRoutes);

$di->setShared('router', $oRouter);