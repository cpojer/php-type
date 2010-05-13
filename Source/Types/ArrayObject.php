<?php

namespace Type;

class ArrayObject extends Iterable implements \IteratorAggregate, \ArrayAccess, \Countable {
	
	public function __construct($data){
		$this->setData(method_exists($data, 'toArray') ? $data->toArray() : $data);
	}
	
	public function __invoke(){
		return $this->toArray();
	}
	
	public function __toString(){
		return '[' . $this->join(', ') . ']';
	}
	
	// Misc
	public function indexOf($value, $strict = true){
		$index = array_search($value, $this->data, $strict);
		return $index !== false ? $index : -1;
	}
	
	public function contains($value, $strict = true){
		return in_array($value, $this->data, $strict);
	}
	
	public function has($key){
		return array_key_exists($key, $this->data);
	}
	
	public function item($at){
		$length = count($this->data);
		
		if ($at < 0){
			$mod = $at % $length;
			if ($mod == 0) $at = 0;
			else $at = $mod + $length;
		}
		
		return ($at < 0 || $at >= $length || !array_key_exists($at, $this->data)) ? null : $this->data[$at];
	}
	
	public function join($separator = ','){
		return implode($separator, $this->data);
	}
	
	public function clear(){
		return $this->setData(array());
	}
	
	public function append($array){
		return call_user_func_array(array($this, 'push'), method_exists($array, 'toArray') ? $array->toArray() : $array);
	}
	
	public function reverse($preserveKeys = false){
		return static::from(array_reverse($this->data, $preserveKeys));
	}
	
	public function slice($begin = 0, $end = false){
		if (func_num_args() < 2) $end = $this->length();
		
		return static::from(array_slice($this->data, $begin, $end));
	}
	
	// Keys / Values
	public function keys(){
		return static::from(array_keys($this->data));
	}
	
	public function values(){
		return static::from(array_values($this->data));
	}
	
	// Stack
	public function push(){
		$args = func_get_args();
		foreach ($args as $arg)
			$this->data[] = $arg;
		
		return $this;
	}
	
	public function pop(){
		return array_pop($this->data);
	}
	
	// Shift
	public function shift(){
		return array_shift($this->data);
	}
	
	public function unshift($data){
		array_unshift($this->data, $data);
		
		return $this;
	}
	
	// Cast
	public function toArray(){
		return $this->data;
	}
	
	public function toJSON(){
		return json_encode($this->data);
	}
	
	// IteratorAggregate
	public function getIterator(){
		return new \ArrayIterator($this->data);
	}
	
	// ArrayAccess
	public function offsetSet($key, $value){
		$this->data[$key] = $value;
	}
	
	public function offsetGet($key){
		return array_key_exists($key, $this->data) ? $this->data[$key] : null;
	}
	
	public function offsetExists($key){
		return array_key_exists($key, $this->data);
	}
	
	public function offsetUnset($key){
		unset($this->data[$key]);
	}
	
	// Countable
	public function count(){
		return count($this->data);
	}
	
	// Static
	protected static function getClassName(){
		return __CLASS__;
	}
	
} 