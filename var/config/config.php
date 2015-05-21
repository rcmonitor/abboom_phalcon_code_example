<?php

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
		'preControllersDir' => __DIR__ . '/../../app/pre-controllers/',
		'modelsDir' => __DIR__ . '/../../app/models/',
		'migrationsDir' => __DIR__ . '/../../app/migrations/',
		'viewsDir' => __DIR__ . '/../../app/views/',
		'pluginsDir' => __DIR__ . '/../../app/plugins/',
		'libraryDir' => __DIR__ . '/../../app/library/',
		'cacheDir' => __DIR__ . '/../cache/',
		'baseUri' => '/abboom2/',
		'logDir' => '/../log/',
	)
));
