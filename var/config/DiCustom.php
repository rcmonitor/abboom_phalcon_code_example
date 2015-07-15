<?php
use App\Modules\Api\VersionLoader;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Request;
use Phalcon\Loader;
use Phalcon\Logger\Adapter\File;
use Phalcon\Mvc\Dispatcher;
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
 * @method Dispatcher getDispatcher() getDispatcher() returns dispatcher object;
 * @method Config getConfig() getConfig() returns configuration object;
 * @method VersionLoader getVersionLoader() getVersionLoader() returns version loader;
 *
 */
class DiCustom extends FactoryDefault{

}


