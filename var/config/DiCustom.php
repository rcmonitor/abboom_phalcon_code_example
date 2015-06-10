<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Request;
use Phalcon\Loader;
use Phalcon\Logger\Adapter\File;
use Phalcon\Mvc\Router;

/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 10.06.15
 * Time: 12:30
 *
 * @method File getFileLogger() getFileLogger() returns file logger;
 * @method Loader getLoader() getLoader() returns class loader;
 * @method Router getRouter() getRouter() returns router;
 * @method Request getRequest() getRequest() returns http request object;
 *
 */
class DiCustom extends FactoryDefault{

}
