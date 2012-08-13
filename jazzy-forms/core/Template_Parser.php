<?php 

function jzzf_parse_template($input) {
    $parser = new Jzzf_Template_Parser($input);
    return $parser->parse();
}

function jzzf_formulas_from_template($input, $prefix) {
    return jzzf_formulas_from_chunks(jzzf_parse_template($input), $prefix);
}

function jzzf_formulas_from_chunks($chunks, $prefix) {
    $formulas = array();
    $counter = 0;
    foreach($chunks as $chunk) {
        if(jzzf_chunk_is_formula($chunk)) {
            $name = jzzf_chunk_name($chunk, $counter, $prefix);
            $formulas[$name] = $chunk;
        }
    }
    return $formulas;
}

function jzzf_apply_template($chunks, $data, $prefix) {
    $result = '';
    $counter = 0;
    foreach($chunks as $chunk) {
        if(jzzf_chunk_is_formula($chunk)) {
            $name = jzzf_chunk_name($chunk, $counter, $prefix);
            $result .= $data[$name];
        } else {
            $result .= $chunk;
        }
    }
    return $result;
}

function jzzf_chunk_is_formula($chunk) {
    return is_array($chunk);
}

function jzzf_chunk_name($chunk, &$counter, $prefix) {
    if($chunk[0]=='v') {
        $name = $chunk[1];                
    } else {
        $name = "_inline_${counter}_${prefix}";
        $counter++;
    }
    return $name;
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

