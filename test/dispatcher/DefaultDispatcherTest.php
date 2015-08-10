<?php
use App\Util\HC;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Test\UnitTestCase;

/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 07.07.15
 * Time: 11:42
 */
class DefaultDispatcherTest extends UnitTestCase{


	/**
	 * @var Dispatcher $dispatcher
	 */
	private $dispatcher;


	/**
	 * @var Router $router
	 */
	private $router;


	public function setUp(){
		parent::setUp();

		$this->dispatcher = $this->di->getDispatcher();

		$this->router = new Router(false);
	}


	/**
	 * @dataProvider routesProvider
	 *
	 * @param $arRoute
	 * @param $strUri
	 * @param $strClassName
	 */
	public function testRoutes($arRoute, $strUri, $strClassName){
		$this->router->add($arRoute['route'], $arRoute['parameters'])
			->setName($arRoute['name']);

		$this->router->handle($strUri);

		$boolMatched = $this->router->wasMatched();
		$this->assertTrue($boolMatched, 'failed to match ' . $strUri);

		$strRouteName = $this->router->getMatchedRoute()->getName();
		$this->assertEquals($arRoute['name'], $strRouteName, 'matched wrong route');

		$this->setUpDispatcher();
		$this->dispatcher->dispatch();

		$strControllerClassName = $this->dispatcher->getControllerClass();
		$this->assertEquals($strClassName, $strControllerClassName, 'wrong controller class name');

	}


	public function routesProvider(){
		return require __DIR__ . '/../fixtures/dispatched_routes.php';
	}


	private function setUpDispatcher(){
		$this->dispatcher->setControllerName($this->router->getControllerName());
		$this->dispatcher->setActionName($this->router->getActionName());
		$this->dispatcher->setParams($this->router->getParams());

		$oDispatcherEventManager = new Manager();
		$oDispatcherEventManager->attach('dispatch:beforeDispatch', function(Event $oEvent, Dispatcher $oDispatcher, $data){

			return false;
		});

		$this->dispatcher->setEventsManager($oDispatcherEventManager);
	}
}