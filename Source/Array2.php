<?php

namespace Type;

class Array2 extends ArrayObject {
	
	public function __construct(){
		parent::__construct(func_get_args());
	}
	
	public static function from($data = null){
		$array = new Array2;
		return $array->setData($data);
	}
	
	// Static
	protected static function getClassName(){
		return __CLASS__;
	}
	
}