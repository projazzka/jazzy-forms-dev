<?php

define('DEFDIR', dirname(__FILE__) . '/../def/');

class Test_Common extends PHPUnit_Framework_TestCase {
	function test_all() {
		$lines = file( DEFDIR . $this->infile);
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
