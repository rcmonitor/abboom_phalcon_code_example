<?php
/**
 * Created by PhpStorm.
 * User: tkorzhikov
 * Date: 28.05.15
 * Time: 18:38
 */

namespace Test;
/**
 * Class UnitTest
 */
class UnitTest extends UnitTestCase {



	public function testTestCase() {

		$this->assertEquals('works',
			'works',
			'This is OK'
		);

		$this->assertEquals('works',
			'works1',
			'This wil fail'
		);

	}
}