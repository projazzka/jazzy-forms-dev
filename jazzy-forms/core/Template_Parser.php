<?php 

function jzzf_parse_template($input) {
    $parser = new Jzzf_Template_Parser($input);
    return $parser->parse();
}

class Jzzf_Template_Parser {
    
    function __construct($input) {
        $this->rest = $input;
        $this->output = array();
    }
    
    function get_next_tag($rest) {
        $open = strpos($rest, '{{');
        if($open === false)
            return false;
        $close = strpos($rest, '}}', $open);
        if($close === false) {
            throw new Exception('Unclosed placeholder tag');
        }
        $before = substr($rest, 0, $open);
        $after = substr($rest, $close+2);
        $tag = substr($rest, $open+2, $close-$open-2);
        return array($before, $tag, $after);
    }

    function parse() {
        while(true) {
            $result = $this->get_next_tag($this->rest);
            if($result === false)
                break;
            list($before, $tag, $after) = $result;
            if(strlen($before)) {
                $this->output[] = $before;
            }
            $this->output[] = jzzf_parse($tag);
            $this->rest = $after;
        }
        if(strlen($this->rest)) {
            $this->output[] = $this->rest;
        }
        return $this->output;
    }
}

