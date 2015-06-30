<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 19.06.15
 * Time: 18:07
 */

namespace Test\Route;


use App\Modules\Api\ApiRoutes;
use Phalcon\Di;
use Phalcon\Mvc\Router;
use Test\UnitTestCase;

/**
 * Class ApiModuleRouteTest
 * @package Test\Route
 *
 * @coversDefaultClass App\Modules\Api\ApiRoutes
 *
 */
class ApiModuleRouteTest extends UnitTestCase{


	/**
	 * @var Router
	 */
	private $router;


	private $routes;


	public function setUp($di = null){

		parent::setUp();

		/**
		 * @type \DiCustom $di
		 */
		$di = $this->di;

		$oConfig = $di->getConfig();

		$oLoader = $di->getLoader();

		$oLoader->registerNamespaces(array(
			'App\Modules\Api' => $oConfig->application->modulesDir . '/api'
		), true);

		$oRouter = new Router(false);

		$di->setShared('router', $oRouter);

		$this->router = $di->getRouter();


		$this->router->mount(new ApiRoutes());

		$this->setExistingRoutes();

	}


	/**
	 *
	 */
	public function testOne(){

		$this->assertInternalType('object', $this->router, 'wrong type of a router');
		$this->assertInstanceOf('\Phalcon\Mvc\Router', $this->router, 'router has wrong class');
	}


	/**
	 * @covers initialize
	 *
	 * @dataProvider easyMatchRoutesDataProvider
	 */
	public function testMatchEasyRoutes($strUri, $strModule, $strController, $strAction, $strRouteName, $arParameters){
		$this->router->handle($strUri);

		$boolMatched = $this->router->wasMatched();

		$this->assertTrue($boolMatched, 'route does not match when it should');


		$this->assertEquals($strRouteName, $this->router->getMatchedRoute()->getName()
			, 'matched wrong route: ' . $this->router->getMatchedRoute()->getPattern());

		$this->assertEquals($strModule, $this->router->getModuleName(), 'wrong module name');
		$this->assertEquals($strController, $this->router->getControllerName(), 'wrong controller name');
		$this->assertEquals($strAction, $this->router->getActionName(), 'wrong action name');

		$arActualParameters = $this->router->getParams();

		foreach ($arParameters as $key => $value) {
			$this->assertArrayHasKey($key, $arParameters, 'key "' . $key . '" not found');
			$this->assertEquals($arParameters[$key], $arActualParameters[$key], 'parameter "' . $key . '" mismatch');
		}

	}


	/**
	 * @covers initialize
	 *
	 * @dataProvider easyMismatchRoutesDataProvider
	 *
	 * @param $strUri
	 */
	public function testMismatchEasyRoutes($strUri){
		$this->router->handle($strUri);

		$boolMatched = $this->router->wasMatched();

		$this->assertFalse($boolMatched, 'route matched when it should not');
	}


	public function easyMatchRoutesDataProvider(){

		$arRoutes = require __DIR__ . '/../fixtures/routes.php';

		return $arRoutes['api']['match'];
	}


	public function easyMismatchRoutesDataProvider(){
		$arRoutes = require __DIR__ . '/../fixtures/routes.php';

		return $arRoutes['api']['mismatch'];
	}


	private function setExistingRoutes(){
		$arRoutes = $this->router->getRoutes();

		/**
		 * @type Router\Route $oRoute
		 */
		foreach ($arRoutes as $oRoute) {
			$strRouteName = $oRoute->getName();
			$this->routes[$strRouteName] = $oRoute->getPattern();
		}

	}


	public function tearDown(){

		$this->router->clear();

		parent::tearDown();
	}


}