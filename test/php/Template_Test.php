<?php

require_once('../../jazzy-forms/core/Template_Parser.php');
require_once('Test_Common.php');

// function parser mock function
function jzzf_parse($input) {
	if($input === '') {
		return array();
	}
	
	switch($input) {
		case 'id':
			return json_decode('[["v", "id"]]');
		case 'id2':
			return json_decode('[["v", "id2"]]');
		case 'a+b':
			return json_decode('[["v", "a"], ["v", "b"], ["o", "+"]]');
		case '':
			return array();
	}
}

/**
 * @backupGlobals disabled
 */
class Parser_Test extends Test_Common {

	function __construct() {
		$this->infile = 'template_test.csv';
	}

	function setUp() {
	}
	
	function tearDown() {
	}

	function check($name, $input, $json) {
        echo "$name\n";
        $result = jzzf_parse_template(json_decode($input));
        $this->assertEquals(json_decode($json), $result, $name);
	}	
}
