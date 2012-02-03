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
        $result = $this->comparison();
        if($this->rest) {
            throw new Exception('unexpected trailing symbols');
        }
        return $result;
    }

    private function comparison() {
        return $this->operation('comparison', array('<=', '>=', '<', '>', '=', '<>'), 'sum');
    }

    private function sum() {
        return $this->operation('sum', array('+', '-'), 'product');
    }
    
    private function product() {
        return $this->operation('product', array('*', '/'), 'exponentiation');
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
        $result = $this->comparison();
        if($result) {
            $num++;
        }
        while(true) {
            if($this->ahead(')')) {
                break;
            }
            if($this->ahead(',')) {
                $this->consume();
                $next = $this->comparison();
                $result = array_merge($result, $next);
                $num++;
            }
        }
        $this->consume(); // closing bracket
        return array($num, $result);
    }

    private function func() {
        $id = $this->consume();
        $this->consume();
        list($num, $args) = $this->arguments();
        return array_merge($args, array(array('f', strtolower($id[1]), $num)));
    }
    
    private function variable() {
        $id = $this->consume();
        return array(array('v', strtolower($id[1])));
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
                return $this->negative();
            }
        }
        else if($this->ahead(array('n', 's'))) { // number or string
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
