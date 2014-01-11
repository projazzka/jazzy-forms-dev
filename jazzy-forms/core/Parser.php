<?php

/* (* Extended Backus-Naur Form (EBNF): *)
  
formula = comparison;
comparison = concatenation, [("<" | ">" | "<=" | "=>" | "<>"), comparison];
concatenation = sum, [ "&", concatenation ];
sum = product, [("+" | "-"), sum];
product = exponentiation, [("*" | "/"), product];
exponentiation = negation, ["^", exponentiation];
negation = ["-"], percentage
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
    public function __construct($tokens) {
        $this->rest = $tokens;
    }

    public function output() {
        $result = $this->comparison();
        if($this->rest) {
            throw new Exception('unexpected trailing symbols');
        }
        return $result;
    }

    private function comparison() {
        return $this->operation('comparison', array('<=', '>=', '<', '>', '=', '<>'), 'concatenation');
    }
    
    private function concatenation() {
        return $this->operation('concatenation', array('&'), 'sum');
    }

    private function sum() {
        return $this->operation('sum', array('+', '-'), 'product');
    }
    
    private function product() {
        return $this->operation('product', array('*', '/'), 'exponentiation');
    }
    
    private function exponentiation() {
        return $this->operation('exponentiation', '^', 'negation');
    }
    
    private function operation($name, $operators, $subordinate) {
        $left = $this->$subordinate();
        if(!$left) {
            return array();
        }
        if($this->ahead($operators)) {
            $op = $this->consume();
            $right = $this->$name();
            if(!$right) {
                throw new Exception('missing right operand');
                return array();
            }
            return array('o', $op[0], $left, $right);
        }
        return $left;
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
        $num = 0;
        $result = array();
        $first = $this->comparison();
        if($first) {
            $result[] = $first;
        }
        while(true) {
            if($this->ahead(')')) {
                break;
            }
            if($this->ahead(',')) {
                $this->consume();
                $next = $this->comparison();
                $result[] = $next;
                $num++;
            } else {
                throw new Exception("Closing bracket or comma expected");
            }
        }
        $this->consume(); // closing bracket
        return $result;
    }

    private function func() {
        $id = $this->consume();
        $this->consume();
        $args = $this->arguments();
        return array_merge(array('f', strtolower($id[1])), $args);
    }
    
    private function variable() {
        $id = $this->consume();
        return array('v', strtolower($id[1]));
    }
        
    private function association() {
        $this->consume();
        $content = $this->comparison();
        if(!$content) {
            throw new Exception('Empty bracket term');
        }
        if(!$this->ahead(')')) {
            throw new Exception('Close bracket expected');
        }
        $this->consume();
        return $content;
    }

    private function negation() {
        if($this->ahead('-')) {
            $this->consume();
            if($this->ahead('n')) {
                $num = $this->consume();
                $num[1] *= (-1);
                return $num;
            } else {
                $positive = $this->percentage();
                    if(!$positive) {
                    throw new Exception('missing negation operand');
                    return array();
                }
                return array("o", "-", array("n", 0), $positive);
            }
        } else {
            return $this->percentage();
        }
    }

    private function percentage() {
        $value = $this->term();
        if($this->ahead('%')) {
            if(!$value) {
                throw new Exception("Unexpected percentage sign");
            }
            $this->consume();
            if($value[0] == 'n') {
                $value[1] /= 100;
                return $value;
            } else {
                return array("o", "/", $value, array("n", 100));
            }
        }
        return $value;
    }
        
    private function term() {
        //$this->dump();
        if($this->complete()) {
            return array();
        }
        else if($this->ahead(array('n', 's'))) { // number or string
            return $this->consume();
        }
        else if($this->ahead('i')) { // identifier
            if($this->ahead('(', 1)) {
                return $this->func();
            }
            return $this->variable();
        }
        else if($this->ahead('(')) {
            return $this->association();
        }
        return null;
    }
    
    // for debugging only
    private function dump() {
        print json_encode($this->rest) . "\n";
    }
}
