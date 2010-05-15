<?php

namespace Type;

abstract class Iterable extends Type {
	
	public function length(){
		return $this->count();
	}
	
	// Iterator Methods
	public function each($fn){
		foreach ($this as $key => $value)
			$fn($value, $key, $this);
		
		return $this;
	}
	
	public function map($fn){
		$results = array();
		
		foreach ($this as $key => $value)
			$results[$key] = $fn($value, $key, $this);
		
		return static::from($results);
	}
	
	public function filter($fn, $preserveKeys = false){
		$results = array();
		
		foreach ($this as $key => $value)
			if ($fn($value, $key, $this))
				$preserveKeys ? $results[$key] = $value : $results[] = $value;
		
		return static::from($results);
	}
	
	public function every($fn){
		foreach($this as $key => $value)
			if (!$fn($value, $key, $this)) return false;
		
		return true;
	}
	
	public function some($fn){
		foreach($this as $key => $value)
			if ($fn($value, $key, $this)) return true;

		return false;
	}
	
}