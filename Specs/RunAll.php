<?php

error_reporting(E_ALL | E_STRICT);

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once '../Source/Type.php';
require_once '../Source/Iterable.php';
require_once '../Source/ArrayObject.php';
require_once '../Source/Array2.php';
require_once '../Source/String.php';

require_once './Type.php';
require_once './Iterable.php';
require_once './ArrayObject.php';
require_once './Array2.php';
require_once './String.php';

class RunAll {
	
	public static function run(){
		\PHPUnit_TextUI_TestRunner::run(self::suite());
	}
	
	public static function suite(){
		$suite = new \PHPUnit_Framework_TestSuite('Type Tests');
		$suite->addTestSuite('Tests\Type\TypeTest');
		$suite->addTestSuite('Tests\Type\IterableTest');
		$suite->addTestSuite('Tests\Type\ArrayObjectTest');
		$suite->addTestSuite('Tests\Type\Array2Test');
		$suite->addTestSuite('Tests\Type\StringTest');

		return $suite;
	}
	
}

if (!defined('PHPUnit_MAIN_METHOD'))
	define('PHPUnit_MAIN_METHOD', 'RunAll::run');

if (PHPUnit_MAIN_METHOD == 'RunAll::run')
	RunAll::run();