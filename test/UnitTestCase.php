<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 28.05.15
 * Time: 18:33
 */

namespace Test;


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

	public function setUp(Phalcon\DiInterface $di = NULL, Phalcon\Config $config = NULL) {

		// Загрузка дополнительных сервисов, которые могут потребоваться во время тестирования
		$di = DI::getDefault();

		// получаем любые компоненты DI, если у вас есть настройки, не забудьте передать их родителю

		parent::setUp($di);

		$this->_loaded = true;

//		echo 'loaded: ';
//		var_dump($this->_loaded);
	}

	/**
	 * Проверка на то, что тест правильно настроен
	 * @throws \PHPUnit_Framework_IncompleteTestError;
	 */
//	public function __destruct() {
//		if(!$this->_loaded) {
//			throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp()');
//		}
//	}


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