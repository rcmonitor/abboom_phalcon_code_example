<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 19.06.15
 * Time: 18:15
 */
return array(
	'test' => array(
		'match' => array(
			array('/api/web/v1.1', 'index', 'index', 'syntax_version', array('major' => '1', 'minor' => '1')),
			array('/api/web/v1_1.8', 'index', 'index', 'simple_version', array('version' => '1_1.8')),
			array('/api/web/v1', 'index', 'index', 'simple_version', array('version' => '1')),
			array('/api/web/v1/user', 'user', 'index', 'single_controller'),
			array('/api/web/v12.42/user/find', 'user', 'find', 'syntax_version_action_controller', array('major' => '12', 'minor' => '42')),
			array('/api/mobile/v45.13/user/show/11568/15/1', 'user', 'show', 'syntax_version_action_controller_parameters',
				array('major' => '45', 'minor' => '13', 0 => '11568', 1 => '15', 2 => '1')
			),
			array('/api/mobile/v45.13/user/show/11568', 'user', 'show', 'media_syntax_version_action_controller_id',
				array('major' => '45', 'minor' => '13', 'id' => '11568', 'media' => 'mobile'),
			),
			array('/api/iot/v45.13/user/show/115683', 'user', 'show', 'media_syntax_version_action_controller_id',
				array('major' => '45', 'minor' => '13', 'id' => '115683', 'media' => 'iot')
			),
		),
		'mismatch' => array(
		),
	),
	'api' => array(
		'match' => array(
//			array('/api/test/v1.4/user/show/11568', 'user', 'show', 'version_action_controller_id',
//				array('version' => '1.4', 'id' => '11568', 'media' => 'mobile'),
//			),
			array('/api/mobile/v45.13/user/show/11568', 'api', 'user', 'show', 'media_syntax_version_action_controller_id',
				array('major' => '45', 'minor' => '13', 'id' => '11568', 'media' => 'mobile'),
			),
			array('/api/iot/v45.13/user/show/115683', 'api', 'user', 'show', 'media_syntax_version_action_controller_id',
				array('major' => '45', 'minor' => '13', 'id' => '115683', 'media' => 'iot')
			),
			array('/api/web/v1.2/location/get/56831', 'api', 'location', 'get', 'media_syntax_version_action_controller_id',
				array('major' => '1', 'minor' => '2', 'id' => '56831', 'media' => 'web')
			),
		),
		'mismatch' => array(
			array('/api/web/v1_2'),
		),
	),
);
