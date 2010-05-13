<?php

namespace Type;

class String extends Iterable implements \IteratorAggregate, \ArrayAccess, \Countable {
	
	public function __construct($data){
		if (is_array($data)) $data = implode($data);
		
		$this->setData('' . (method_exists($data, 'toString') ? $data->toString() : $data));
	}
	
	// Misc
	public function indexOf($value){
		$index = strpos($this->data, $value);
		return $index !== false ? $index : -1;
	}
	
	public function contains($value){
		return $this->indexOf($value) == -1 ? false : true;
	}
	
	public function split($separator = null){
		$data = $this->data;
		
		if ($separator === null) $data = array($this->data);
		else if ($separator === '') $data = $this->toArray();
		else $data = explode($separator, $this->data);
		
		return new ArrayObject($data);
	}
	
	public function clear(){
		return $this->setData('');
	}
	
	public function reverse(){
		return static::from(strrev($this->data));
	}
	
	public function trim(){
		return static::from(trim($this->data));
	}
	
	public function camelCase(){
		return static::from(str_replace('-', '', preg_replace_callback('/-\D/', function($matches){
			return strtoupper($matches[0]);
		}, $this->data)));
	}
	
	public function substitute($data){
		$keys = array();
		foreach ($data as $key => $value)
			$keys[] = '{' . $key . '}';
		
		$string = str_replace($keys, array_values($data), $this->data);
		return static::from(preg_replace('/\{([^{}]+)\}/', '', $string));
	}
	
	// Cast
	public function toArray(){
		return str_split($this->data);
	}
	
	public function toJSON(){
		return json_encode($this->data);
	}
	
	// IteratorAggregate
	public function getIterator(){
		return new \ArrayIterator($this->toArray());
	}
	
	// ArrayAccess
	public function offsetSet($key, $value){
		$this->data[$key] = $value;
	}
	
	public function offsetGet($key){
		return !empty($this->data[$key]) ? $this->data[$key] : null;
	}
	
	public function offsetExists($key){
		return !empty($this->data[$key]);
	}
	
	public function offsetUnset($key){
		$this->data[$key] = null;
	}
	
	// Countable
	public function count(){
		return strlen($this->data);
	}
	
	// Static
	protected static function getClassName(){
		return __CLASS__;
	}
	
}