<?php
/**
 * Created by PhpStorm.
 * User: rcmonitor
 * Date: 28.05.15
 * Time: 18:33
 */

namespace Test;


use App\Util\HC;
use App\Util\Tester;
use Phalcon\DI,
	\Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase {

	/**
	 * @var \Voice\Cache
	 */
	protected $_cache;

	/**
	 * @var \Phalcon\Config
	 */
	protected $_config;

	/**
	 * @var bool
	 */
	private $_loaded = false;
	/**
	 * @var bool
	 */
	private $_provider = false;


	public static function setUpBeforeClass(){
		require 'test_bootstrap.php';

		parent::setUpBeforeClass();

	}

	public function setUp(Phalcon\DiInterface $di = NULL, Phalcon\Config $config = NULL) {

		$di = DI::getDefault();

		parent::setUp($di);

		$this->_loaded = true;

	}

	/**
	 * Проверка на то, что тест правильно настроен
	 * @throws \PHPUnit_Framework_IncompleteTestError;
	 */
	public function __destruct() {

		if(!$this->_loaded && !$this->_provider) {
			throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp()');
		}
	}


	protected function isProvider(){
		$this->_provider = true;
	}

//	public function tearDown() {
//
//		Di::reset();
//
//		parent::tearDown();
//
////		if(!$this->_loaded) {
////			throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp()');
////		}
//	}
}