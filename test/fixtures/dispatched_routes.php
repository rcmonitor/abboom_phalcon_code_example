<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 07.07.15
 * Time: 11:54
 */
return array(
//	array(
//		array(
//			'route' => '/{media}/v{major:[0-9]{1,2}}\.{minor:[0-9]{1,2}}/:controller/:action/:int',
//			'parameters' => array(
//				'controller' => 4,
//				'action' => 5,
//				'id' => 6
//			),
//			'name' => 'media_syntax_version_action_controller_id',
//		),
//		'/api/web/v1.0/test/test/15789',
//		'App\Modules\Api\TestController',
//	),
	array(
		array(
			'route' => '/:controller/:action',
			'parameters' => array(
				'controller' => 1,
				'action' => 2,
			),
			'name' => 'version_action',
		),
		'/test/test',
		'TestController',
	),
	array(
		array(
			'route' => '/:controller',
			'parameters' => array(
				'controller' => 1,
			),
			'name' => 'action',
		),
		'/test',
		'TestController',
	),
);