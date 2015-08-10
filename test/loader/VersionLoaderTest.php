<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 21.07.15
 * Time: 15:11
 */

namespace test\loader;


use App\Modules\Api\ApiRoutes;
use App\Modules\Api\Module;
use App\Util\HC;
use App\Util\Tester;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\Router;
use Test\UnitTestCase;

class VersionLoaderTest extends UnitTestCase{


	/**
	 * @var ModuleDefinitionInterface $module
	 */
	private $module;


	/**
	 * @var Loader
	 */
	private $loader;


	public function setUp(){
		parent::setUp();

		$this->loader = $this->di->getLoader();

		$strModule = 'App\Modules\Api';

		$strModuleDir = $this->di->getConfig()->application->modulesDir . DIRECTORY_SEPARATOR . 'api';


		$this->loader->registerNamespaces(array(
			$strModule => $strModuleDir,
		), true);

		$this->module = new Module();
	}


	/**
	 * @covers VersionLoader::load
	 *
	 * @dataProvider matchedVersionRoutesProvider
	 *
	 * @param $strRoute
	 */
	public function testMatchedVersionRoutes($strRoute){

		$this->module->registerAutoloaders($this->di);
		$this->module->registerServices($this->di);

		$this->di->getRouter()->handle($strRoute);

		$this->setUpDispatcher();

		$this->di->getDispatcher()->dispatch();
		$strResponse = $this->di->getDispatcher()->getReturnedValue();



		$this->assertNotEmpty($strResponse, 'return from controller is empty');

		$this->assertInternalType('string', $strResponse, 'wrong type of return from controller');
	}


	public function matchedVersionRoutesProvider(){
		$this->isProvider();

		return require __DIR__ . '/../fixtures/version/controller_routes.php';
	}


	private function setUpDispatcher(){
		/**
		 * @type Dispatcher $oDispatcher
		 */
		$oDispatcher = $this->di->getDispatcher();

		/**
		 * @type Router $oRouter
		 */
		$oRouter = $this->di->getRouter();
		
		$oDispatcher->setControllerName($oRouter->getControllerName());
		$oDispatcher->setActionName($oRouter->getActionName());
		$oDispatcher->setParams($oRouter->getParams());
		$oDispatcher->setNamespaceName($oRouter->getNamespaceName());
	}

}