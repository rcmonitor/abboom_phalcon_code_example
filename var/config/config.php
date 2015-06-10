<?php

require_once 'DiCustom.php';

//use Phalcon\Di\FactoryDefault;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
//$di = new FactoryDefault();

$di = new DiCustom();

$di->set('config', function(){
	return new \Phalcon\Config(array(
		'database' => array(
			'adapter' => 'Mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'dbname' => 'test',
			'charset' => 'utf8',
		),
		'application' => array(
			'controllersDir' => __DIR__ . '/../../app/controllers/',
			'preControllersDir' => __DIR__ . '/../../app/pre_controllers/',
			'modelsDir' => __DIR__ . '/../../app/models/',
			'migrationsDir' => __DIR__ . '/../../app/migrations/',
			'viewsDir' => __DIR__ . '/../../app/views/',
			'pluginsDir' => __DIR__ . '/../../app/plugins/',
			'libraryDir' => __DIR__ . '/../../vendor',
//			'libraryDir' => __DIR__ . '/../../app/library/',
			'cacheDir' => __DIR__ . '/../cache/',
			'logDir' => __DIR__ . '/../log/',
			'baseUri' => '/abboom2/',
			'testDir' => __DIR__ . '/../../test/',
			'modulesDir' => __DIR__ . '/../../app/modules',
			'hooksDir' => __DIR__ . '/../../app/hooks',
		)
	));

}, true);

