<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 20.05.15
 * Time: 11:16
 */


require __DIR__ . '/../var/config/DiCustom.php';

//define('TEST_ROOT_PATH', __DIR__);
//define('APP_ROOT_PATH', __DIR__ . '/../');

//set_include_path(
//	__DIR__ . PATH_SEPARATOR . get_include_path()
//);


use Phalcon\Di;

require_once __DIR__ . '/../vendor/autoload.php';

$di = new DiCustom();
Di::reset();

Di::setDefault($di);

/**
 * Read the configuration
 */
$oConfig = include __DIR__ . "/../var/config/config.php";

$di->setShared('config', $oConfig);

//$oConfig = $di->getConfig();


$eventsManager = new \Phalcon\Events\Manager();
$loader = new \Phalcon\Loader();

//$eventsManager->attach('loader', function($event, $loader) {
//	/**
//	 * @type \Phalcon\Events\Event $event
//	 * @type \Phalcon\Loader $loader
//	 */
//	if ($event->getType() == 'beforeCheckPath') {
//		echo 'trying: ' . $loader->getCheckedPath() . PHP_EOL;
//	}elseif($event->getType() == 'pathFound'){
//		echo 'gotcha: ' . $loader->getCheckedPath();
//	}elseif($event->getType() == 'afterCheckPath'){
//		echo 'not found: ' . $loader->getCheckedPath() . PHP_EOL;
//	}
//});
//
//$loader->setEventsManager($eventsManager);

$loader->registerNamespaces(array(
	'Test' => __DIR__,
));

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
	array(
		$oConfig->application->controllersDir,
		$oConfig->application->modelsDir,
		$oConfig->application->preControllersDir,
		$oConfig->application->testDir,
	)
)->register();

$di->setShared('loader', $loader);

///**
// * Read auto-loader
// */
//include __DIR__ . "/../var/config/loader.php";

/**
 * Read services
 */
include __DIR__ . "/../var/config/services.php";


//Di::setDefault($di);
