<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 09.06.15
 * Time: 10:48
 */

namespace App\Hooks;


use App\Util\U;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\DiInterface;
use Phalcon\Exception;
use Phalcon\Http\Request;
use Phalcon\Logger\Adapter\File;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;

class ModuleRouter{


	/**
	 * @var \DiCustom
	 */
	protected $di;


	private $app;


	private $knownModules;


	public function __construct(Application $app){

		$this->app = $app;

		$this->di = $app->di;

		$this->knownModules = array(
			'regular' => array(
				'className' => 'App\Modules\Regular\Module',
				'path' => '../app/modules/regular/Module.php',
			),
			'api' => array(
				'className' => 'App\Modules\Api\Module',
				'path' => '../app/modules/api/Module.php',
			),
			'blind' => array(
				'className' => 'App\Modules\Blind\Module',
				'path' => '../app/modules/blind/Module.php',
			),
		);
	}


//	public function setDi(DiInterface $di){
//		$this->di = $di;
//
//		$this->app = $this->di->getApplication();
//	}
//
//
//	public function getDi(){
//		return $this->di;
//	}


	/**
	 * registers module according to uri given
	 *
	 * @return bool true if module successfully loaded; <br />
	 * 				false otherwise;
	 */
	public function handle(){

		$boolReturn = false;

		$oLogger = $this->di->getFileLogger();

		$oPreRouter = new Router();

		$oPreRouter->add('/api(.*)', array(
			'module' => 'api',
		));
		$oPreRouter->add('/regular(.*)', array(
			'module' => 'regular'
		));
		$oPreRouter->add('/blind(.*)', array(
			'module' => 'blind',
		));

		$oPreRouter->handle();

		$strModuleName = $oPreRouter->getModuleName();


		/**
		 * @type Request $oRequest
		 */
		$oRequest = $this->di->getRequest();

		if(array_key_exists($strModuleName, $this->knownModules)){
			$this->app->registerModules(array(
				$strModuleName => $this->knownModules[$strModuleName],
			));

			$this->app->setDefaultModule($strModuleName);

			$boolReturn = true;

			$oLogger->debug(__CLASS__ . ': ' . $oRequest->getURI() . ' leads to module: ' . $strModuleName);
		}else{
			if(!U::isLegacy()){
				$strMsg = 'failed to load phalcon module';
			}else{
				$strMsg = 'loading old backend';
			}
			$oLogger->debug(__CLASS__ . ': ' . $strMsg . ' for "' . $oRequest->getUri() . '"');
		}

		return $boolReturn;
	}

}