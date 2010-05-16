<?php

namespace Tests\Type;

use Type\ArrayObject;

class TestClass {
	
	public function toArray(){
		return array(2, 4, 6);
	}
	
}

class ArrayObjectTest extends \PHPUnit_Framework_TestCase {
	
	public function setUp(){
		$this->array = new ArrayObject(array(1, 2, 3));
	}
	
	public function testConstructor(){
		// Copy!
		$copy = new ArrayObject($this->array);
		$this->assertEquals($copy, $this->array);
		$this->assertNotSame($copy, $this->array);
		
		$test = new TestClass;
		$this->assertEquals(ArrayObject::from($test)->toArray(), array(2, 4, 6));
	}
	
	public function testClone(){
		$clone = clone $this->array;
		$this->assertEquals($clone, $this->array);
		$this->assertNotSame($clone, $this->array);
	}
	
	public function testInvoke(){
		$array = $this->array;
		
		$this->assertTrue(is_callable($array));
		$this->assertEquals($array(), $this->array->toArray());
		$this->assertEquals($array(), array(1, 2, 3));
		$this->assertNotSame($array(), $this->array);
	}
	
	public function testToString(){
		$this->assertEquals('' . $this->array, '[1, 2, 3]');
	}
	
	public function testModify(){
		unset($this->array[0]);
		
		$this->assertEquals($this->array[0], null);
		
		$this->array[5] = 1;
		$this->assertEquals($this->array[1], 2);
		$this->assertEquals($this->array[2], 3);
		$this->assertEquals($this->array[3], null);
		$this->assertEquals($this->array[4], null);
		$this->assertEquals($this->array[5], 1);
	}
	
	public function testNoWarning(){
		// Should not throw
		$this->assertEquals($this->array['undefined'], null);
	}
	
	public function testFrom(){
		$this->assertEquals(ArrayObject::from(array(1, 2, 3)), $this->array);
		
		// Copy!
		$copy = ArrayObject::from($this->array);
		$this->assertEquals($copy, $this->array);
		$this->assertNotSame($copy, $this->array);
	}
	
	public function testIndexOf(){
		$this->assertEquals($this->array->indexOf(1), 0);
		$this->assertEquals($this->array->indexOf(2), 1);
		$this->assertEquals($this->array->indexOf(3), 2);
		$this->assertEquals($this->array->indexOf('undefined'), -1);
	}
	
	public function testContains(){
		$this->assertTrue($this->array->contains(1));
		$this->assertTrue($this->array->contains(3));
		
		$this->assertFalse($this->array->contains('3'), true);
		$this->assertTrue($this->array->contains('3', false));
		
		$this->assertFalse($this->array->contains(5));
		$this->assertFalse($this->array->contains('undefined'));
	}
	
	public function testHas(){
		$this->assertTrue($this->array->has(0));
		$this->assertTrue($this->array->has(2));
		$this->assertTrue($this->array->has('2'));
		
		$this->assertFalse($this->array->has(5));
		$this->assertFalse($this->array->has('undefined'));
	}
	
	public function testLength(){
		$this->assertEquals($this->array->length(), 3);
	}
	
	public function testItem(){
		$this->assertEquals($this->array->item(0), 1);
		$this->assertEquals($this->array->item(1), 2);
		$this->assertEquals($this->array->item(2), 3);
		
		$this->assertEquals($this->array->item(3), null);
		$this->assertEquals($this->array->item(-1), 3);
		$this->assertEquals($this->array->item(-2), 2);
		$this->assertEquals($this->array->item(-3), 1);
	}
	
	public function testJoin(){
		$this->assertEquals($this->array->join(), '1,2,3');
		$this->assertEquals($this->array->join(' '), '1 2 3');
	}
	
	public function testClear(){
		$this->assertEquals($this->array->clear()->toArray(), array());
		$this->assertEquals($this->array->length(), 0);
	}
	
	public function testReverse(){
		$reverse = $this->array->reverse();
		$this->assertNotSame($reverse, $this->array);
		$this->assertEquals($reverse(), array(3, 2, 1));
	}
	
	public function testSlice(){
		$sliced = $this->array->slice();
		$this->assertTrue($sliced instanceof ArrayObject);
		$this->assertNotSame($sliced, $this->array);
		
		$this->assertEquals($sliced(), array(1, 2, 3));
		
		$sliced = $this->array->slice(1);
		$this->assertTrue($sliced instanceof ArrayObject);
		$this->assertNotSame($sliced, $this->array);
		$this->assertEquals($sliced(), array(2, 3));
		
		$sliced = $this->array->slice(1, 1);
		$this->assertTrue($sliced instanceof ArrayObject);
		$this->assertNotSame($sliced, $this->array);
		$this->assertEquals($sliced(), array(2));
		
		$sliced = $this->array->slice(1, -2);
		$this->assertTrue($sliced instanceof ArrayObject);
		$this->assertNotSame($sliced, $this->array);
		$this->assertEquals($sliced(), array());
	}
	
	public function testRemove(){
		$this->assertEquals($this->array->remove(2)->toArray(), array(1, 2 => 3));
		$this->assertEquals($this->array->remove(5)->toArray(), array(1, 2 => 3));
		$this->assertEquals($this->array->remove('3')->toArray(), array(1, 2 => 3));
	}
	
	public function testClean(){
		$array = new ArrayObject(array(0, null, '0', 1, '', 2, 3, false));
		// ->values() because the array is not being reindexed
		$this->assertEquals($array->clean()->values()->toArray(), array('0', 1, 2, 3));
	}
	
	public function testKeys(){
		$keys = $this->array->keys();
		$this->assertTrue($keys instanceOf ArrayObject);
		$this->assertEquals($keys(), array(0, 1, 2));
	}
	
	public function testValues(){
		$values = $this->array->values();
		$this->assertTrue($values instanceOf ArrayObject);
		$this->assertEquals($values(), array(1, 2, 3));
	}
	
	public function testPush(){
		$this->array->push(1)->push(1, 2, 3);
		
		$this->assertEquals($this->array->toArray(), array(1, 2, 3, 1, 1, 2, 3));
	}

	public function testAppend(){
		$this->array->append(new ArrayObject(array(4, 5, 6)))->append(array(7, 8, 9));
		
		$this->assertEquals($this->array->toArray(), array(1, 2, 3, 4, 5, 6, 7, 8, 9));
	}

	public function testPop(){
		$third = $this->array->pop();
		$second = $this->array->pop();
		
		$this->assertEquals($third, 3);
		$this->assertEquals($second, 2);
		$this->assertEquals($this->array->length(), 1);
		$this->assertEquals($this->array[0], 1);
		$this->assertEquals($this->array[1], null);
		$this->assertEquals($this->array[2], null);
	}
	
	public function testShift(){
		$first = $this->array->shift();
		$this->assertEquals($first, 1);
		
		$second = $this->array->shift();
		$this->assertEquals($second, 2);
		
		$this->assertEquals($this->array[0], 3);
	}
	
	public function testUnshift(){
		$this->array->unshift(1)->unshift(3);
		
		$this->assertEquals($this->array->toArray(), array(3, 1, 1, 2, 3));
	}
	
	public function testForeach(){
		$array = array();
		
		foreach ($this->array as $key => $value)
			$array[$key] = $value;
		
		$this->assertEquals($this->array->toArray(), $array);
	}
	
	public function testFilter(){
		$filtered = $this->array->filter(function($value, $key, $this){
			return ($value >= 2);
		}, true);
		
		$this->assertTrue($filtered instanceof ArrayObject);
		$this->assertEquals($filtered(), array(
			1 => 2,
			2 => 3
		));
	}

}