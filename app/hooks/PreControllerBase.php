<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 26.05.15
 * Time: 17:16
 */

namespace App\Hooks;


class PreControllerBase{

	private $di;


	public function __construct(\Phalcon\Di $di){
		$this->di = $di;
	}


	public function register(){

		$oLogger = $this->di->getService('fileLogger');
		$oLogger->info('registering base pre-controller');

		echo 'some';
	}


	public function handle(\Phalcon\Events\Event $oEvent, \Phalcon\Mvc\Dispatcher $oDispatcher){
		$oLogger = $this->di->get('fileLogger');
		$oLogger->info($oEvent->getType() . ' happened in ' . $oDispatcher->getControllerClass() . '::' . $oDispatcher->getActionName());
	}


}