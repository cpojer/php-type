PHP-Types (PHP 5.3)
===================

banana banana banana

### Specs

* Run the "run" script in the Specs directory

### Array Example
	
	use Type;
	
	$array = new Array2(1, 2, 3);
	$array2 = $array->map(function($value){
		return $value * 2;
	});
	
	$array instanceof Array2; // true
	
	foreach ($array2 as $value)
		// 2, 4, 6
	
	$array2[] = 8;
	$array2[] = 10;
	
	$array2->contains(8); // true
	
	count($array2); // 5
	
	echo $array2; // [2,4,6,8,10]
	
	// Cast
	ArrayObject::from($someArray);
	Array2::from($someArray);

### String Example

	use Type;
	
	$string = new String('abc');
	$string->reverse(); // 'cba';
	
	foreach ($string as $character);
		// a, b, c
	
	$string->each($fn);
	
	String::from('Hello {name}')->substitute(array('name' => 'Banana')); // Hello Banana

See the Source or Specs for more