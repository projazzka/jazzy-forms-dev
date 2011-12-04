<?php

require_once('../../jazzy-forms/core/Tokenizer.php');

/**
 * @backupGlobals disabled
 */
class TokenizerTest extends PHPUnit_Framework_TestCase {

	private $db;
	
	function __construct() {
	}

	function setUp() {
	}
	
	function tearDown() {
	}

	function check($name, $input, $json) {
        $result = jzzf_tokenize($input);
        $this->assertEquals(json_decode($json), $result, $name);
	}
	
	function test_empty() {
		$tokens = jzzf_tokenize('');
		$this->assertTrue(is_array($tokens));
		$this->assertEquals(0, count($tokens));
	}

	function test_all() {
		$lines = file(dirname(__FILE__) . '/../def/tokenizer_test.csv');
		if($lines === false) {
			$this->assertTrue(false, 'Can\t load test definition file');
		}
		foreach($lines as $line) {
			if($line[0] == '#')
				continue;
			$arr = str_getcsv($line, '|', "'");
			if(count($arr)!=3) {
				$this->assertTrue(false, 'Expected 3 columns in definition file');
			}
			$this->check(trim($arr[0]), trim($arr[1]), trim($arr[2]));
		}
	}

}
