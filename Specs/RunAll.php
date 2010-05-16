<?php

error_reporting(E_ALL | E_STRICT);

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

$namespace = trim(file_get_contents(__DIR__ . '/../namespace'));

spl_autoload_register(function($className) use ($namespace){
	$className = explode('\\', $className);
	if ($className[0] == $namespace) array_shift($className);
	
	$file = __DIR__ . '/../Source/' . implode('/', $className) . '.php';
	if (file_exists($file)) require_once $file;
});

$$namespace = function() use ($namespace){
	$tests = array();
	foreach (glob(__DIR__ . '/*.php') as $file){
		$name = basename($file, '.php');
		if ($name == 'RunAll') continue;
		
		$tests[] = $name;
		require_once $file;
	}
	
	return $tests;
};

if (!class_exists('RunAll')){
	class RunAll {
		
		public static function run(){
			\PHPUnit_TextUI_TestRunner::run(self::suite());
		}
		
		public static function suite(){
			$namespace = trim(file_get_contents(__DIR__ . '/../namespace'));
			
			$suite = new \PHPUnit_Framework_TestSuite($namespace . ' Tests');
			
			global $$namespace;
			foreach ($$namespace() as $testCase)
				$suite->addTestSuite('Tests\\' . $namespace . '\\' . $testCase . 'Test');

			return $suite;
		}
		
	}
}

if (!defined('PHPUnit_MAIN_METHOD'))
	define('PHPUnit_MAIN_METHOD', $namespace);

if (PHPUnit_MAIN_METHOD == $namespace)
	RunAll::run();