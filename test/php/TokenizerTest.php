<?php

require_once('../../jazzy-forms/core/Tokenizer.php');
require_once('TestCommon.php');

/**
 * @backupGlobals disabled
 */

class TokenizerTest extends TestCommon {

	function __construct() {
		$this->infile = 'tokenizer_test.csv';
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

}
