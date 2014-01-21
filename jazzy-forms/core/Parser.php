<?php

/* (* Extended Backus-Naur Form (EBNF): *)
  
formula = comparison;
comparison = concatenation, [("<" | ">" | "<=" | "=>" | "<>"), comparison];
concatenation = addition, [ "&", concatenation ];
addition = subtraction, ["+", addition];
subtraction = product, ["-", difference];
multiplication = division, ["*", multiplication];
division = exponentiation, ["/", division];
exponentiation = additive_inverse, ["^", exponentiation];
additive_inverse = ["-"], percentage
percentage = term ["%"]
term = number | string | function | identifier | association;

arguments = comparison, { ",", comparison };
function = identifier, "(", arguments ")";
association = "(", comparison, ")"

*/


function jzzf_parse($notation) {
    try {
        $tokens = jzzf_tokenize($notation);
        return jzzf_parse_tokens($tokens);
    } catch( Exception $e ) {
        return null;
    }        
}

function jzzf_parse_tokens($in) {
    try {
        $tokenizer = new Jzzf_Parser($in);
        return $tokenizer->output();
    } catch( Exception $e ) {
        return null;
    }        
}

class Jzzf_Parser {
    private $rest;
    private $rule_stack;
    private $result_stack;
    
    public function __construct($tokens) {
        $this->rest = $tokens;
        $this->execution_stack = array();
        $this->result_stack = array();
    }
    
    private function push_execution($step, $data=null) {
        array_push($this->execution_stack, array($step, $data));
    }
    
    private function pop_execution() {
        return array_pop($this->execution_stack);
    }

    private function push_result($result) {
        array_push($this->result_stack, $result);
    }
    
    private function pop_result() {
        return array_pop($this->result_stack);
    }
    
    public function output() {
        $this->push_execution('operation', 'comparison');
        while($this->execution_stack) {
            //$this->dump();
            list($step, $data) = $this->pop_execution();
            $this->$step($data);
        }
        //$this->dump();
        if($this->rest) {
            throw new Exception('unexpected trailing symbols');
        }
        if(!$this->result_stack) {
            $result = array();
        } else {
            $result = $this->pop_result();
        }
        if($this->result_stack) {
            throw new Exception('internal parsing error');            
        }
        return $result;
    }

    private function operation($rule) {
        $left_subrules = array(
            'comparison' => 'concatenation',
            'concatenation' => 'addition',
            'addition' => 'subtraction',
            'subtraction' => 'multiplication',
            'multiplication' => 'division',
            'division' => 'exponentiation',
            'exponentiation' => 'additive_inverse'
        );
        $this->push_execution('operation_ahead', $rule);
        $left_subrule = $left_subrules[$rule];
        if($left_subrule == 'additive_inverse') {
            $this->push_execution($left_subrule);
        } else {
            $this->push_execution('operation', $left_subrules[$rule]);
        }
    }

    private function operation_ahead($rule) {
        static $operators = array(
            'comparison' => array("<", ">", "<=", ">=", "<>", "="),
            'concatenation' => array("&"),
            'addition' => array("+"),
            'subtraction' => array("-"),
            'multiplication' => array("*"),
            'division' => array("/"),
            'exponentiation' => array("^")
        );
        if($this->ahead($operators[$rule])) {
            $operator = $this->consume();
            $this->push_execution('operation_production', $operator[0]);
            $this->push_execution('operation', $rule);
        }
    }
    
    private function operation_production($operator) {
        $right = $this->pop_result();
        $left = $this->pop_result();
        $this->push_result(array('o', $operator, $left, $right));
    }
        
    private function ahead($tokens, $skip=0) {
        if(count($this->rest) <= $skip) {
            return false;
        }
        $ahead = $this->rest[$skip][0];
        if(is_array($tokens)) {
            foreach($tokens as $token) {
                if($token == $ahead) {
                    return true;
                }
            }
            return false;
        } else {
            return $tokens == $ahead;
        }
    }

    private function complete() {
        return !$this->rest;
    }
    
    private function consume() {
        $head = $this->rest[0];
        $this->rest = array_slice($this->rest, 1);
        return $head;
    }

    private function arguments() {
        if(!$this->ahead(')')) {
            $this->push_execution('arguments_production', 1);
            $this->push_execution('operation', 'comparison');
        } else {
            $this->push_execution('arguments_production', 0);            
        }
    }
    
    private function arguments_production($number) {
        if($this->ahead(')')) {
            $this->consume();
            $arguments = array();
            for($i=0; $i<$number; $i++) {
                $argument = $this->pop_result();
                array_unshift($arguments, $argument);
            }
            $this->push_result($arguments);            
        } elseif($this->ahead(',')) {
            $this->consume();
            $this->push_execution('arguments_production', $number+1);
            $this->push_execution('operation', 'comparison');
        } else {
            throw new Exception('Closing bracket or comma expected');            
        }
    }

    private function func() {
        $id = $this->consume();
        $this->consume();
        $this->push_execution('func_production', strtolower($id[1]));
        $this->push_execution('arguments', 0);
    }
    
    private function func_production($id) {
        $args = $this->pop_result();
        $result = array_merge(array('f', $id), $args);
        $this->push_result($result);
    }
    
    private function variable() {
        $id = $this->consume();
        $this->push_result(array('v', strtolower($id[1])));
    }
        
    private function association() {
        $this->consume();
        
        $this->push_execution('association_production');
        $this->push_execution('operation', 'comparison');
    }
    
    private function association_production() {
        $content = $this->pop_result();
        if(!$this->ahead(')')) {
            throw new Exception('Close bracket expected');
        }
        $this->consume();
        $this->push_result($content);
    }

    private function additive_inverse() {
        if($this->ahead('-')) {
            $this->consume();
            $this->push_execution('additive_inverse_production');
        }
        $this->push_execution('percentage');
    }
    
    private function additive_inverse_production() {
        $operand = $this->pop_result();
        if(!$operand) {
            throw new Exception('missing operand for additive inverse');
        }
        if($operand[0] == 'n') {
            $operand[1] *= (-1);
            $this->push_result($operand);
        } else {
            $this->push_result(array("o", "-", array("n", 0), $operand));
        }
    }

    private function percentage() {
        $this->push_execution('percentage_production');
        $this->push_execution('term');
    }

    private function percentage_production() {
        $value = $this->pop_result();
        if($this->ahead(array('%'))) {
            $this->consume();
            if($value[0] == 'n') {
                $value[1] /= 100;
                $this->push_result($value);
            } else {
                $this->push_result(array("o", "/", $value, array("n", 100)));
            }
        } else {
            $this->push_result($value);
        }
    }
        
    private function term() {
        if($this->complete()) {
            $this->push_result(array());
        }
        else if($this->ahead(array('n', 's'))) { // number or string
            $this->push_result($this->consume());
        }
        else if($this->ahead('i')) { // identifier
            if($this->ahead('(', 1)) {
                $this->push_execution('func');
            } else {
                $this->push_execution('variable');
            }
        }
        else if($this->ahead('(')) {
            $this->push_execution('association');
        }
        else {
            $this->push_result(array());
        }
    }
    
    // for debugging only
    private function dump() {
        print "Rest: " . json_encode($this->rest) . "\n";
        print "Execution stack: " . json_encode($this->execution_stack) . "\n";
        print "Result stack: " . json_encode($this->result_stack) . "\n";
    }
}
