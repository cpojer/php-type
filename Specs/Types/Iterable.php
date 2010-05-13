<?php

namespace Tests\Type;

use Type\Iterable, Type\String, Type\Array2;

class IterableTest extends \PHPUnit_Framework_TestCase {
	
	public function provider(){
		return array(
			array(new String("banana")),
			array(new Array2('b', 'a', 'n', 'a', 'n', 'a'))
		);
	}
	
	public function providerInt(){
		return array(
			array(new String(123)),
			array(new Array2(1, 2, 3))
		);
	}
	
	/**
	* @dataProvider provider
	*/
	public function testLength($iterator){
		$this->assertEquals($iterator->length(), 6);
	}
	
	/**
	* @dataProvider provider
	*/
	public function testForeach($iterator){
		$values = array('b', 'a', 'n', 'a', 'n', 'a');

		foreach($iterator as $key => $value)
			$this->assertEquals($value, $values[$key]);
	}
	
	/**
	* @dataProvider provider
	*/
	public function testArrayAccess($iterator){
		$this->assertEquals($iterator[0], 'b');
		
		$iterator[1] = 'c';
		$this->assertEquals($iterator[1], 'c');
		
		//unset($iterator[3]);
		//$this->assertEquals($iterator->length(), 5);
	}
	
	/**
	* @dataProvider providerInt
	*/
	public function testEach($iterator){
		$class = get_class($iterator);
		$keys = array();
		$array = $iterator->toArray();
		
		$self = $this;
		$iterator->each(function($value, $key, $this) use (&$keys, $array, $self, $class){
			array_push($keys, $key);
			$self->assertEquals($value, $array[$key]);
			$self->assertTrue($this instanceof $class);
		});
		
		$this->assertEquals($keys, array_keys($array));
	}
	
	/**
	* @dataProvider providerInt
	*/
	public function testMap($iterator){
		$class = get_class($iterator);
		$self = $this;
		$mapped = $iterator->map(function($value, $key, $this) use ($self, $class){
			$self->assertTrue($this instanceof $class);
			return (int)($value * 2);
		});
		
		$this->assertTrue($mapped instanceof $class);
		$this->assertEquals($mapped->toArray(), array(2, 4, 6));
	}
	
	/**
	* @dataProvider providerInt
	*/
	public function testFilter($iterator){
		$class = get_class($iterator);
		$self = $this;
		$filtered = $iterator->filter(function($value, $key, $this) use ($self, $class){
			$self->assertTrue($this instanceof $class);
			return ($value >= 2);
		});
		
		$this->assertTrue($filtered instanceof $class);
		$this->assertEquals($filtered->toArray(), array(2, 3));
	}
	
	/**
	* @dataProvider providerInt
	*/
	public function testEvery($iterator){
		$this->assertTrue($iterator->every(function($value){
			return $value > 0;
		}));
		
		$this->assertFalse($iterator->every(function($value){
			return $value > 3;
		}));
	}
	
	/**
	* @dataProvider providerInt
	*/
	public function testSome($iterator){
		$this->assertTrue($iterator->some(function($value){
			return $value > 0;
		}));
		
		$this->assertTrue($iterator->some(function($value){
			return $value > 2;
		}));
		
		$this->assertFalse($iterator->some(function($value){
			return $value > 3;
		}));
	}

}