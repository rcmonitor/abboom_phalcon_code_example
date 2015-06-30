<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 26.05.15
 * Time: 16:23
 */

namespace test;


class InitialTest extends \PHPUnit_Framework_TestCase
{


	public function setUp(){
		echo 'tests started' . PHP_EOL;
	}


	public function testOne(){
		$this->assertEquals(1, 1, 'test failed');
	}


	/**
	 * @group excluded
	 */
	public function testTwo(){
		$this->assertEquals(1, 2, 'test completed');
	}
}