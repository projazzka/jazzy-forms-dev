function jazzy_forms($, form_id, jzzf_data, jzzf_types, jzzf_dependencies, jzzf_formulas) {
    
    jzzf_precision = Math.pow(10,6);
    
    $(function() {
        bind();
    });
    
    function element(id) {
        return $('#jzzf_' + form_id + '_' + id);
    }
    
    function element_id(element) {
        var chunks = element.attr('id').split('_');
        return chunks[chunks.length - 1];
    }
    
    function bind() {
        var id;
        for(id in jzzf_types) {
            update(id);
            switch(jzzf_types[id]) {
                case 'r':
                    element(id).find('input:radio').bind('change ready', function() {
                        update(element_id($(this).parents('.jzzf_radio')));
                    });
                    break;
                default:
                    element(id).bind('change ready', function() {
                        update(element_id($(this)));
                    });
                    
            }
        }
    }

    var just_updated;
    
    function update(id) {
        just_updated = [];
        updating_worker(id);
    }
           
    function updating_worker(id) {
        update_dependent(id);
        if(jzzf_types[id] != 'f' || id in just_updated) {
            return;
        }
        element(id).val(Math.round(evaluate(id)*jzzf_precision)/jzzf_precision);
        just_updated.push(id);        
    }

    function update_dependent(id) {
        if(id in jzzf_dependencies) {
            var deps = jzzf_dependencies[id];
            for(var i=0; i<deps.length; i++) {
                updating_worker(deps[i]);
            }
        }
    }
    
    function evaluate(id) {
        switch(jzzf_types[id]) {
            case 'n':
                return element(id).val() * jzzf_data[id];
            case 'r':
                var idx = element(id).find('input:checked').parent().index();
                if(idx>=0) {
                    return jzzf_data[id][idx];
                } else {
                    return 0;
                }
            case "c":
                return element(id).is(':checked') ? jzzf_data[id][1] : jzzf_data[id][0];
            case 'd':
                var idx = element(id).find('option:selected').index();
                if(idx>=0) {
                    return jzzf_data[id][idx];
                } else {
                    return 0;
                }
            case 'f':
                return formula(id);
        }
        return 0;
    }
    
    var functions = {
        'abs': function(args) {
            return Math.abs(args[0]);
        }
    }
    
    function formula(id) {
        var stack = [];
        var f = jzzf_formulas[id];
        for(var i=0; i<f.length; i++) {
            switch(f[i][0]) {
                case 'n':
                    stack.push(f[i][1]);
                    break;
                case 'v':
                    stack.push(evaluate(f[i][1]));
                    break;
                case 'o':
                    var right = parseFloat(stack.pop());
                    var left = parseFloat(stack.pop());
                    var result;
                    switch(f[i][1]) {
                        case '+':
                            result = left + right;
                            break;
                        case '-':
                            result = left - right;
                            break;
                        case '*':
                            result = left * right;
                            break;
                        case '/':
                            result = left / right;
                            break;
                        case '^':
                            result = Math.pow(left, right);
                            break;
                    }
                    stack.push(result);
                    break;
                case 'f':
                    var args=[];
                    for(var j=0; j<f[i][2]; j++) {
                        args.unshift(stack.pop());
                    }
                    stack.push(functions[f[i][1]](args));
                    break;
            }
        }
        return stack.pop();
    }
    
}