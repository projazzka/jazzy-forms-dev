<?php

function jzzf_parse($notation) {
    $tokens = jzzf_tokenize($notation);
    return jzzf_parse_tokens($tokens);
}

function jzzf_parse_tokens($in) {
    $tokenizer = new Jzzf_Parser($in);
    return $tokenizer->output();
}

class Jzzf_Parser {
    public function __construct($tokens) {
        $this->rest = $tokens;
    }

    public function output() {
        $result = $this->sum();
        if($this->rest) {
            throw new Exception('unexpected trailing symbols');
        }
        return $result;
    }

    private function sum() {
        if($this->ahead('-')) {
            $this->consume();
            if($this->ahead('n')) {
                $negative = $this->consume();
                return array(array('n', 0-$negative[1]));
            }
            $negative = $this->sum();
            if(!$negative) {
                throw new Exception('negation without operand');
            }
            return array(array('n', 0)) + $negative + array(array('o', '-'));
        }
        return $this->operation('sum', '+-', 'product');
    }
    
    private function product() {
        return $this->operation('product', '*/', 'exponentiation');
    }
    
    private function exponentiation() {
        return $this->operation('exponentiation', '^', 'term');
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
            return array_merge($left,$right,array(array('o', $op[0])));
        }
        return $left;
    }
    
    private function ahead($pattern, $skip=0) {
        if(count($this->rest) <= $skip) {
            return false;
        }
        return strstr($pattern, $this->rest[$skip][0]);
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
        $result = $this->sum();
        while(true) {
            if($this->ahead(')')) {
                break;
            }
            if($this->ahead(',')) {
                $this->consume();
                $next = $this->sum();
                $result = array_merge($result, $next);
            }
        }
        $this->consume(); // closing bracket
        return $result;
    }

    private function func() {
        $id = $this->consume();
        $this->consume();
        $args = $this->arguments();
        return array_merge($args, array(array('f', $id[1], count($args))));
    }
    
    private function variable() {
        $id = $this->consume();
        return array(array('v', $id[1]));
    }
        
    private function association() {
        $this->consume();
        $content = $this->sum();
        if(!$content) {
            throw new Exception('Empty bracket term');
        }
        if(!$this->ahead(')')) {
            throw new Exception('Close bracket expected');
        }
        $this->consume();
        return $content;
    }

    private function negative() {
        $this->consume();
        if($this->ahead('n')) {
            $num = $this->consume();
            $num[1] *= (-1);
            return array($num);
        return $this->sum();
        }
    }
        
    private function term() {
        if($this->complete()) {
            return array();
        }
        else if($this->ahead('-')) {
            if($this->ahead('n', 1)) {
                $this->negative();
            }
        }
        else if($this->ahead('ns')) { // number or string
            return array($this->consume());
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
        return array();
    }
}
