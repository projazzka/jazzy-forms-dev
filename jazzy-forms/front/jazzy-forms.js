/*
    This file is part of the WordPress plugin "Jazzy Forms"
    Copyright (C) 2012 by Igor Prochazka. www.jazzyforms.com
    Jazzy Forms is licensed under the GNU General Public License, version 3.
*/

function jazzy_forms($, form_id, graph) {
    
    var all_ids = [];
    var cache = {};
    
    jzzf_precision = Math.pow(10,9);
    function prcsn(x) {
        return Math.round(x*jzzf_precision)/jzzf_precision;
    }
    
    function retrieve_all_ids() {
        for(id in graph.types) {
            all_ids.push(id);
        }
    }
    
    $(function() {
        retrieve_all_ids();
        update(all_ids);
        bind();
    });
    
    function element(id) {
        return $('#jzzf_' + form_id + '_' + id);
    }
    
    function element_id(element) {
        var id = element.attr('id');
        return id.substr(id.indexOf('_', 5)+1);
    }
    
    function bind() {
        var id;
        for(id in graph.types) {
            if(graph.form.realtime) {
                bind_realtime_update(id);
            }
            if(graph.types[id] == 'u') {
                element(id).click(function() {
                    update(all_ids);
                });
            }
        }
    }

    function bind_realtime_update(id) {
        switch(graph.types[id]) {
        case 'r':
            element(id).find('input:radio').bind('change ready', function() {
                update([element_id($(this).parents('.jzzf_radio'))]);
            });
            break;
        default:
            element(id).bind('change ready', function() {
                update([element_id($(this))]);
            });
        }
    }
    
    var just_updated;
    
    function update(ids) {
        just_updated = [];
        for(var i=0; i<ids.length; i++) {
            var id = ids[i];
            delete cache[id]
            updating_worker(id);
        }
    }
    
    function sanitize_result(val, id) {
        var f = parseFloat(val);
        if(!isNaN(f)) {
            val = f;
        }
        switch(typeof val) {
            case 'undefined':
                val = 'Invalid formula';
                break;
            case 'number':
                if(!isNaN(val)) {
                    val = jzzf_format(val, graph.params[id]);
                }
                break;
            case 'boolean':
                val = val ? 1 : 0;
                break;
        }
        return val;
    }
    
    function updating_worker(id) {
        update_dependent(id);
        if(graph.types[id] != 'f' || id in just_updated) {
            return;
        }
        element(id).val(sanitize_result(evaluate(id), id));
        just_updated.push(id);        
    }

    function update_dependent(id) {
        if(id in graph.dependencies) {
            var deps = graph.dependencies[id];
            for(var i=0; i<deps.length; i++) {
                updating_worker(deps[i]);
            }
        }
    }
    
    function evaluate(id) {
        var result;
        if(!(id in cache) || (graph.types[id] == 'f' && !(id in just_updated))) {
            result = evaluation_worker(id);
            cache[id] = result;
        } else {
            result = cache[id];
        }
        return result;
    }
    
    function evaluation_worker(id) {
        switch(graph.types[id]) {
            case 'n':
                return element(id).val() * graph.data[id];
            case 'r':
                var idx = element(id).find('input:checked').parent().index();
                if(idx>=0) {
                    return graph.data[id][idx];
                } else {
                    return 0;
                }
            case "c":
                return element(id).is(':checked') ? graph.data[id][1] : graph.data[id][0];
            case 'd':
                var idx = element(id).find('option:selected').index();
                if(idx>=0) {
                    return graph.data[id][idx];
                } else {
                    return 0;
                }
            case 'f':
                return formula(id);
        }
        return 0;
    }
            
    function formula(id) {
        var stack = [];
        var f = graph.formulas[id];
        if(!f) {
            return undefined;
        }
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
                        case '<':
                            result = prcsn(left) < prcsn(right);
                            break;
                        case '>':
                            result = prcsn(left) > prcsn(right);
                            break;
                        case '<>':
                            result = prcsn(left) != prcsn(right);
                            break;
                        case '<=':
                            result = prcsn(left) <= prcsn(right);
                            break;
                        case '>=':
                            result = prcsn(left) >= prcsn(right);
                            break;
                        case '=':
                            result = prcsn(left) == prcsn(right);
                            break;
                    }
                    stack.push(result);
                    break;
                case 'f':
                    var args=[];
                    for(var j=0; j<f[i][2]; j++) {
                        args.unshift(stack.pop());
                    }
                    stack.push(jzzf_functions(f[i][1], args));
                    break;
            }
        }
        return stack.pop();
    }
    
}

function jzzf_functions(id, args) {
    
    function arg(idx, def) {
        if(idx >= args.length) {
            return def;
        }
        return args[idx];
    }

    var all = {
        'abs': function() {
            return Math.abs(arg(0));
        },
        'round': function() {
            var digits = arg(1, 0);
            var decimal = Math.pow(10, digits);
            return Math.round(arg(0)*decimal)/decimal;
        },
        'roundup': function() {
            var digits = arg(1, 0);
            var decimal = Math.pow(10, digits);
            var x = arg(0);
            return (x > 0) ? Math.ceil(arg(0)*decimal)/decimal : Math.floor(arg(0)*decimal)/decimal;
        },
        'rounddown': function() {
            var digits = arg(1, 0);
            var decimal = Math.pow(10, digits);
            var x = arg(0);
            return (x > 0) ? Math.floor(arg(0)*decimal)/decimal : Math.ceil(arg(0)*decimal)/decimal;
        },
        'sqrt': function() {
            return Math.sqrt(arg(0));
        },
        'sin': function() {
            return Math.sin(arg(0));
        },
        'cos': function() {
            return Math.cos(arg(0));
        },
        'tan': function() {
            return Math.tan(arg(0));
        },
        'asin': function() {
            return Math.asin(arg(0));
        },
        'acos': function() {
            return Math.acos(arg(0));
        },
        'atan': function() {
            return Math.atan(arg(0));
        },
        'pi': function() {
            return Math.PI;
        },
        'not': function() {
            return !arg(0);
        },
        'and': function() {
            return arg(0) && arg(1);
        },
        'or': function() {
            return arg(0) || arg(1);
        },
        'if': function() {
            return arg(0) ? arg(1) : arg(2, false);
        },
        'true': function() {
            return true;
        },
        'false': function() {
            return false;
        }
        
    };

    return (all[id])();        
}

function jzzf_format(input, args) {
    
    function get_sign() {
        if(parts[0].substr(0,1) == '-') {
            sign = '-';
            natural = parts[0].substr(1);
        } else {
            sign = '';
            natural = parts[0];
        }
    }
    
    function get_decimals() {
        if(parts.length > 1) {
            decimals = parts[1];
        } else {
            decimals = '';
        }
    }

    function round() {
        var precision = Math.pow(10, args.decimals);
        input = Math.round(input*precision)/precision;
    }
    
    function leading_zeros() {
        if(args.fixed && args.decimals > decimals.length) {
            decimals += Array(args.decimals - decimals.length + 1).join("0");
        }
    }
    
    function trailing_zeros() {
        if(args.zeros > natural.length) {
            natural = Array(args.zeros - natural.length + 1).join("0") + natural;
        }
    }
    
    function thousands_separator() {
        if(args.thousands.length) {
            var len = natural.length;
            var result = natural.substr(0, len % 3);
            for(var i=len % 3; i<len; i+=3) {
                if(result.length) {
                    result += args.thousands;
                }
                result += natural.substr(i, 3);
            }
            natural = result;
        }
    }
    
    round();
    
    var str = "" + input;
    var parts = str.split('.');
    var sign;
    var natural;
    var decimals;
    
    get_sign();
    get_decimals();
    leading_zeros();
    trailing_zeros();
    thousands_separator();

    return sign + args.prefix + natural + (decimals.length ? args.point + decimals + args.postfix : args.postfix);
}
