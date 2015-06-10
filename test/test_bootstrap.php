<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 20.05.15
 * Time: 11:16
 */


//define('TEST_ROOT_PATH', __DIR__);
//define('APP_ROOT_PATH', __DIR__ . '/../');

//set_include_path(
//	__DIR__ . PATH_SEPARATOR . get_include_path()
//);


require_once __DIR__ . '/../vendor/autoload.php';
/**
 * Read the configuration
 */
$config = include __DIR__ . "/../var/config/config.php";


$eventsManager = new \Phalcon\Events\Manager();
$loader = new \Phalcon\Loader();

$eventsManager->attach('loader', function($event, $loader) {
	/**
	 * @type \Phalcon\Events\Event $event
	 * @type \Phalcon\Loader $loader
	 */
	if ($event->getType() == 'beforeCheckPath') {
		echo 'trying: ' . $loader->getCheckedPath() . PHP_EOL;
	}elseif($event->getType() == 'pathFound'){
		echo 'gotcha: ' . $loader->getCheckedPath();
	}elseif($event->getType() == 'afterCheckPath'){
		echo 'not found: ' . $loader->getCheckedPath() . PHP_EOL;
	}
});

$loader->setEventsManager($eventsManager);

$loader->registerNamespaces(array(
	'Test' => __DIR__,
));

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
	array(
		$config->application->controllersDir,
		$config->application->modelsDir,
		$config->application->preControllersDir,
		$config->application->testDir,
	)
)->register();


///**
// * Read auto-loader
// */
//include __DIR__ . "/../var/config/loader.php";

/**
 * Read services
 */
include __DIR__ . "/../var/config/services.php";
