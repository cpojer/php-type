<?php

namespace Tests\Type;

use Type\ArrayObject, Type\Array2;

class Array2Test extends \PHPUnit_Framework_TestCase {
	
	public function testArray2(){
		$array = new Array2(1, 2, 3);
		
		$this->assertTrue($array instanceof ArrayObject);
		$this->assertEquals($array(), array(1, 2, 3));
	}

}