<?php

function jzzf_tokenize($in) {
    $tokenizer = new Jzzf_Tokenizer($in);
    return $tokenizer->output();
}

class Jzzf_Tokenizer {
    
    public function __construct($input) {
        $this->rest = $input;
        $this->out = array();
    }

    public function output() {
        while(true) {
            $this->rest = ltrim($this->rest);
            if(!$this->rest)
                break;
            if(!$this->operator()) {
                if(!$this->positive()) {
                    if(!$this->bracket()) {
                        if(!$this->string()) {
                            if(!$this->identifier()) {
                                $this->error('Unknown token');
                                return null;
                            }
                        }
                    }
                }
            }
        }
        return $this->out;
    }
            
    private function operator() {
        return $this->match('<=|>=|<>|[\-\+\*\/\^\,<>=&%]');
    }

    private function positive() {
        return $this->match('[0-9]*\\.[0-9]+|[0-9]+|[0-9]+\\.[0-9]*', 'n', true);
    }

    private function bracket() {
        return $this->match('[()]');
    }

    private function string() {
       if($this->rest[0] != '"') {
           return false;
       }
       $i=0;
       $this->advance(1);
       while(true) {
           if($i==strlen($this->rest)) {
               $this->error('Unterminated string');
               return null;
           }
           if($this->rest[$i] == '"') {
               break;
           }
           if($this->rest[$i] == '\\') {
               $i += 2;
           } else {
               $i += 1;
           }
       }
       $this->push('s', stripslashes(substr($this->rest, 0, $i)));
       $this->advance($i+1);
       return true;
    }

    private function identifier() {
       return $this->match('[a-zA-Z_][a-zA-Z0-9_]*', 'i');
    }

    private function match($pattern, $code=null, $toFloat=false) {
       $groups = array();
       $m = preg_match('/^(' . $pattern . ')/', $this->rest, $groups);
       if($m) {
           if($toFloat)
               $content = floatval($groups[0]);
           else
               $content = $groups[0];
           $this->push($code, $content);
           $this->advance(strlen($groups[0]));
           return true;
       }
       return false;
    }

    private function advance($increment) {
        $this->rest = substr($this->rest, $increment);
    }

    private function push($code, $content) {
        if($code) {
            $this->out[] = array($code, $content);
        } else {
            $this->out[] = array($content);
        }
    }

    private function error($msg) {
        throw(new Exception($msg . ':' . $this->rest));
    }
}
