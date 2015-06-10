<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 01.06.15
 * Time: 16:28
 */
$oRoutesGroup = new \Phalcon\Mvc\Router\Group(array(
	'module' => 'api',
	'controller' => 'index'
));

$oRoutesGroup->setPrefix('/api');

$oRoutesGroup->add('/web/v{major:[0-9]{1,2}}.{minor:[0-9]{1,2}}/:controller/:action/:params', array(
	'controller' => 3,
	'action' => 4,
	'params' => 5,
));

//// Еще один маршрут
//$oRoutesGroup->add('/edit/{id}', array(
//	'action' => 'edit'
//));
//
//// Маршрут для действия по умолчанию
//$oRoutesGroup->add('/blog', array(
//	'controller' => 'blog',
//	'action' => 'index'
//));

return $oRoutesGroup;

