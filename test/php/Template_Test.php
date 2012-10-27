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
	
	function test_empty() {
		$formulas = jzzf_formulas_from_chunks(array(), 'foo');
		$this->assertTrue(is_array($formulas));
		$this->assertEquals(0, count($formulas));
	}
	
	function test_text_only() {
		$chunks = array("anton", "berta", "caesar");
		$formulas = jzzf_formulas_from_chunks($chunks, 'foo');
		$this->assertTrue(is_array($formulas));
		$this->assertEquals(0, count($formulas));
		
		$result = jzzf_apply_template($chunks, array("dummy"=>123), 'foo');
		$this->assertEquals("antonbertacaesar", $result);
	}
	
	function test_inline() {
		$chunks = json_decode('[[["v", "a"], ["v", "b"], ["o", "+"]]]');
		$formulas = jzzf_formulas_from_chunks($chunks, 'foo');
		$this->assertEquals(json_decode('{"_inline_0_foo": [["v", "a"], ["v", "b"], ["o", "+"]]}', true), $formulas);
		
		$result = jzzf_apply_template($chunks, array("_inline_0_foo"=>123), 'foo');
		$this->assertEquals("123", $result);
	}
	
	function test_2_inline() {
		$chunks = json_decode('[[["v", "a"], ["v", "b"], ["o", "+"]], [["v", "c"], ["v", "d"], ["o", "*"]]]');
		$formulas = jzzf_formulas_from_chunks($chunks, 'foo');
		$this->assertEquals(json_decode('{"_inline_0_foo": [["v", "a"], ["v", "b"], ["o", "+"]], "_inline_1_foo": [["v", "c"], ["v", "d"], ["o", "*"]]}', true), $formulas);
		
		$result = jzzf_apply_template($chunks, array("_inline_0_foo"=>123, "_inline_1_foo"=>987), 'foo');
		$this->assertEquals("123987", $result);
	}
}
