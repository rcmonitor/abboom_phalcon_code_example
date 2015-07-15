<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 30.06.15
 * Time: 15:10
 */

namespace App\Modules\Api;


use App\Core\Interfaces\ILoader;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router\Route;
use Rcmonitor\Checker;

class VersionLoader implements InjectionAwareInterface, ILoader{


	/**
	 * @var \DiCustom
	 */
	protected $_di;


//	private $routes;


	/**
	 * @var Dispatcher $dispatcher
	 */
	private $dispatcher;


	private $logger;




	public function setDi(DiInterface $di){
		$this->_di = $di;

		$this->dispatcher = $this->_di->getDispatcher();
		$this->logger = $this->_di->getFileLogger();
	}


	public function getDi(){
		return $this->_di;
	}


	public function load(){

		$strContext = __CLASS__ . '->' . __FUNCTION__ . ': ';

		$oLogger = $this->_di->getFileLogger();


		$oDispatcher = $this->_di->getDispatcher();

		$arParams = $oDispatcher->getParams();


		if($strPath = $this->pathFinder($arParams['media'], $arParams['major'], $arParams['minor'])){

			$oLogger->debug($strContext . ' got path: ' . $strPath);

			$oLoader = $this->_di->getLoader();

			$arRequiredNamespace = array(
				$this->dispatcher->getNamespaceName() => $strPath
			);

			$oLoader->registerNamespaces($arRequiredNamespace, true);
			$oLogger->debug($strContext . ' registered namespace: ' . print_r($arRequiredNamespace, true));

			$arNewNamespaces = $oLoader->getNamespaces();
			$oLogger->debug($strContext . ' complete namespaces list is:  ' . print_r($arNewNamespaces, true));

		}else{

			$oLogger->debug($strContext . ' got no path: "' . $strPath . '"');
		}


//		$oDispatcher->get




//		$this->setExistingRoutes();
//
//		$oLogger->debug(__CLASS__ . ': routes are: ' . print_r($this->routes, true));
//
//		$oRouter = $this->_di->getRouter();
//
////		$oRouter->handle($oRouter->getRewriteUri());
//
//		$boolMatched = $oRouter->wasMatched();
//
//		$strMatched = $boolMatched ? 'matched' : 'mismatched';
//
//		$oLogger->debug(__CLASS__ . ': route: ' . $strMatched);
////		$oRouter->get
//
//		$oLogger->debug(__CLASS__ . ': route matched for "' . $oRouter->getRewriteUri() . '"  is: ' . $oRouter->getMatchedRoute()->getPattern());


		$oLogger->debug(__CLASS__ . ': trying to dispatch:'
			. ' module: ' . $oDispatcher->getModuleName()
			. ' media: ' . $arParams['media']
			. ' version: v' . $arParams['major'] . '_' . $arParams['minor']
			. ' controller: ' . $oDispatcher->getControllerName()
			. ' controller class: ' . $oDispatcher->getControllerClass()
			. ' action: ' . $oDispatcher->getActionName()
			. ' active method: ' . $oDispatcher->getActiveMethod()
		);


	}


	private function pathFinder($strMedia, $intMajorVersion, $intMinorVersion){
		$strReturn = '';

		$oLogger = $this->_di->getFileLogger();

//		$oChecker = new Checker();

		$strBaseDir = __DIR__ . DIRECTORY_SEPARATOR . $strMedia . DIRECTORY_SEPARATOR . 'v' . $intMajorVersion . '_';

		$intMinorVersion = (integer) $intMinorVersion;

		for ($i = $intMinorVersion; $i >= 0; $i --){
			$strDir = $strBaseDir . $intMinorVersion . '/controllers';

			if(Checker::methodExists($strDir, $this->dispatcher->getControllerClass(), $this->dispatcher->getActiveMethod())){
				$oLogger->debug(__CLASS__ . '->' . __FUNCTION__ . ':: '
								. $this->dispatcher->getControllerClass() . '->'
								. $this->dispatcher->getActiveMethod()
								. ' lays in ' . $strDir
				);

				$strReturn = $strDir;

				break;

			}else{
				$oLogger->debug(__CLASS__ . '->' . __FUNCTION__ . ':: '
								. $this->dispatcher->getControllerClass() . '->'
								. $this->dispatcher->getActiveMethod()
								. ' not found in ' . $strDir
				);
			}

//			if($strTokens = $oChecker->classExists($strDir, $this->dispatcher->getControllerClass())){
//
//				$oLogger->debug('tokens: ' . $strTokens);
//			}

		}

		return $strReturn;
	}


//	private function setExistingRoutes(){
//		$oRouter = $this->_di->getRouter();
//
//		/**
//		 * @type Route $oRoute
//		 */
//		foreach ($oRouter->getRoutes() as $offset => $oRoute) {
//			if($strName = $oRoute->getName()){
//				$this->routes[$strName] = $oRoute->getPattern();
//			}else{
//				$this->routes[$offset] = $oRoute->getPattern();
//			}
//		}
//
//	}
}