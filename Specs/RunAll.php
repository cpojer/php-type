<?php

error_reporting(E_ALL | E_STRICT);

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once '../Source/Types/Type.php';
require_once '../Source/Types/Iterable.php';
require_once '../Source/Types/ArrayObject.php';
require_once '../Source/Types/Array2.php';
require_once '../Source/Types/String.php';

require_once 'Types/Type.php';
require_once 'Types/Iterable.php';
require_once 'Types/ArrayObject.php';
require_once 'Types/Array2.php';
require_once 'Types/String.php';

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