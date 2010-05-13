<?php

namespace Tests\Type;

use Type\String, Type\ArrayObject;

class StringTest extends \PHPUnit_Framework_TestCase {
	
	public function setUp(){
		$this->string = new String('abc');
	}
	
	public function testIndexOf(){
		$this->assertEquals($this->string->indexOf('a'), 0);
		$this->assertEquals($this->string->indexOf('b'), 1);
		$this->assertEquals($this->string->indexOf('c'), 2);
		$this->assertEquals($this->string->indexOf('d'), -1);
	}
	
	public function testContains(){
		$this->assertEquals($this->string->contains('a'), true);
		$this->assertEquals($this->string->contains('d'), false);
	}
	
	public function testSplit(){
		$array = $this->string->split();
		
		$this->assertEquals($array(), array('abc'));
		$this->assertTrue($array instanceof ArrayObject);
		
		$array = $this->string->split('');

		$this->assertEquals($array(), array('a', 'b', 'c'));
		$this->assertTrue($array instanceof ArrayObject);
		
		$array = $this->string->split('b');

		$this->assertEquals($array(), array('a', 'c'));
		$this->assertTrue($array instanceof ArrayObject);
	}
	
	public function testTrim(){
		$string = String::from(' abc ');
		$this->assertEquals($string->trim()->toString(), 'abc');
		$this->assertNotSame($string, $string->trim());
	}
	
	public function testCamelCase(){
		$this->assertEquals(String::from('i-like-cookies')->camelCase()->toString(), 'iLikeCookies');
		$this->assertEquals(String::from('I-like-cookies')->camelCase()->toString(), 'ILikeCookies');
	}
	
	public function testSubstitute(){
		$this->assertEquals(
			String::from('I am {name}!')->substitute(array('name' => 'Banana'))->toString(),
			'I am Banana!'
		);
		
		$this->assertEquals(
			String::from('I am {undefined}!')->substitute(array('name' => 'Banana'))->toString(),
			'I am !'
		);
	}
	
	public function testClear(){
		$this->assertEquals($this->string->clear()->toString(), '');
	}
	
	public function testReverse(){
		$this->assertEquals($this->string->reverse()->toString(), 'cba');
		$this->assertNotSame($this->string, $this->string->reverse());
	}

}