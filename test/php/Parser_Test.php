<?php

require_once('../../jazzy-forms/core/Parser.php');
require_once('Test_Common.php');

/**
 * @backupGlobals disabled
 */
class Parser_Test extends Test_Common {

	function __construct() {
		$this->infile = 'parser_test.csv';
	}

	function setUp() {
	}
	
	function tearDown() {
	}

    function test_empty() {
        $result = jzzf_parse_tokens(array());
        $this->assertTrue(is_array($result));
        $this->assertEquals(count($result), 0);
    }

	function check($name, $input, $json) {
        $result = jzzf_parse_tokens(json_decode($input));
        $this->assertEquals(json_decode($json), $result, $name);
	}	
}