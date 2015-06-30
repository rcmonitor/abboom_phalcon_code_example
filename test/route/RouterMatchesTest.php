<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 29.06.15
 * Time: 16:08
 */

namespace Test\Route;


use Phalcon\Mvc\Router;
use Test\UnitTestCase;

class RouterMatchesTest extends UnitTestCase{


	/**
	 * @var Router
	 */
	private $router;


	private $routes = array();


	public function setUp(){
		parent::setUp();

		$this->router = new Router();
		$this->router->add('/api/web/v1/:controller', array(
			'module' => 'api',
			'action' => 'index',
			'controller' => 1
		))->setName('single_controller');

		$this->router->add('/api/web/v{version}', array(
			'module' => 'api',
			'action' => 'index',
			'controller' => 'index',
		))->setName('simple_version');

		$this->router->add('/api/web/v{major:[0-9]{1,2}}\.{minor:[0-9]{1,2}}', array(
			'module' => 'api',
			'action' => 'index',
			'controller' => 'index',
		))->setName('syntax_version');

		$this->router->add('/api/web/v{major:[0-9]{1,2}}\.{minor:[0-9]{1,2}}/:controller/:action', array(
			'module' => 'api',
			'action' => 4,
			'controller' => 3,
		))->setName('syntax_version_action_controller');

		$this->router->add('/api/mobile/v{major:[0-9]{1,2}}\.{minor:[0-9]{1,2}}/:controller/:action/:params', array(
			'module' => 'api',
			'action' => 4,
			'controller' => 3,
			'params' => 5
		))->setName('syntax_version_action_controller_parameters');

		$this->router->add('/api/mobile/v{major:[0-9]{1,2}}\.{minor:[0-9]{1,2}}/:controller/:action/:int', array(
			'module' => 'api',
			'action' => 4,
			'controller' => 3,
			'id' => 5
		))->setName('syntax_version_action_controller_id');

		$this->router->add('/api/{media}/v{major:[0-9]{1,2}}\.{minor:[0-9]{1,2}}/:controller/:action/:int', array(
			'module' => 'api',
			'action' => 5,
			'controller' => 4,
			'id' => 6
		))->setName('media_syntax_version_action_controller_id');


		$arRoutes = $this->router->getRoutes();

		/**
		 * @type Router\Route $oRoute
		 */
		foreach ($arRoutes as $oRoute) {
			$this->routes[] = $oRoute->getPattern();
		}

	}


	/**
	 * @dataProvider easyMatchedProvider
	 */
	public function testEasyMatched($strUri, $strController, $strAction, $strRouteName, $arParameters = array()){
		$this->router->handle($strUri);

		$boolMatched = $this->router->wasMatched();

		$this->assertTrue($boolMatched, 'route ' . $strUri . ' does not match any of ' . print_r($this->routes, true) . ' when it should');

		$this->assertEquals($strRouteName, $this->router->getMatchedRoute()->getName(), 'matches wrong route');

		$this->assertEquals($strController, $this->router->getControllerName(), 'wrong controller name');
		$this->assertEquals($strAction, $this->router->getActionName(), 'wrong action name');

		$arActualParameters = $this->router->getParams();

		foreach ($arParameters as $key => $value) {
			$this->assertArrayHasKey($key, $arParameters, 'key "' . $key . '" not found');
			$this->assertEquals($arParameters[$key], $arActualParameters[$key], 'parameter "' . $key . '" mismatch');
		}

	}


	/**
	 * @group excluded
	 * @dataProvider easyMismatchedProvider
	 *
	 * @param $strUri
	 */
	public function testEasyMismatched($strUri){
		$this->router->handle($strUri);

		$boolMatched = $this->router->wasMatched();

		$this->assertFalse($boolMatched, 'matched when should not');
	}


	public function easyMatchedProvider(){
		$arRoutes = require __DIR__ . '/../fixtures/routes.php';

		return $arRoutes['test']['match'];
	}


	public function easyMismatchedProvider(){
		$arRoutes = require __DIR__ . '/../fixtures/routes.php';

		return $arRoutes['test']['mismatch'];
	}

}