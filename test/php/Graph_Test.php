<?php

require('../../jazzy-forms/core/Graph.php');
require('../../jazzy-forms/core/Parser.php');
require('../../jazzy-forms/core/Tokenizer.php');

class Graph_Test extends PHPUnit_Framework_TestCase {
	function setUp() {
	}
	
	function tearDown() {
	}

    function test_empty() {
        $result = jzzf_get_graph(array());
        $this->assertEquals(array('data'=>array(), 'types'=>array(), 'dependencies'=>array(), 'formulas'=>array()), $result);
    }
	
	function test_simple() {
		$elements = array(
			(object) array('id'=> 'num', 'type'=> 'n')
		);
		$graph = jzzf_get_graph($elements);
		extract($graph);
		$this->assertEquals(array('num'=>'n'), $types);
		$this->assertEquals(array(), $dependencies);
		$this->assertEquals(array(), $formulas);
	}

	function test_single_dependency() {
		$elements = array(
			(object) array('id'=> 'num', 'type'=> 'n'),
			(object) array('id'=> 'result', 'type'=> 'f', 'formula' => 'num*2')
		);
		$graph = jzzf_get_graph($elements);
		extract($graph);
		$this->assertEquals(array('num'=>'n', 'result'=>'f'), $types);
		$this->assertEquals(array('num'=>array('result')), $dependencies);
		$this->assertEquals(array('result'=>array(array('v', 'num'), array('n', '2'), array('o', '*'))), $formulas);
	}
	
	function test_multiple_dependency() {
		$elements = array(
			(object) array('id'=> 'num', 'type'=> 'n'),
			(object) array('id'=> 'subtotal', 'type'=> 'f', 'formula' => 'num*2'),
			(object) array('id'=> 'total', 'type'=> 'f', 'formula' => 'subtotal+1')
		);
		$graph = jzzf_get_graph($elements);
		extract($graph);
		$this->assertEquals(array('num'=>'n', 'subtotal'=>'f', 'total'=>'f'), $types);
		$this->assertEquals(array('num'=>array('subtotal'), 'subtotal'=>array('total')), $dependencies);
		$this->assertEquals(
			array(
				'subtotal' => array(array('v', 'num'), array('n', '2'), array('o', '*')),
				'total'=> array(array('v', 'subtotal'), array('n', '1'), array('o', '+'))),
			$formulas
		);
	}
}
