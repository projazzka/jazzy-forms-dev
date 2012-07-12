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
            switch(graph.types[id]) {
                case 'u':
                    element(id).click(function() {
                        update(all_ids);
                    });
                    break;
                case 'e':
                    element(id).click(function() {
                        send_email(this);
                    });
                    break;
                case 'x':
                    element(id).click(function() {
                        reset_messages();
                    })
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
    
    function set_message(node, msg) {
        $(node).parentsUntil('.jzzf_row').siblings('.jzzf_message').text(msg);    
    }
    
    function reset_messages() {
        $('.jzzf_form_' + form_id + ' .jzzf_message').text('');
    }
    
    function send_email(button) {
        set_message(button, graph.form.email.sending);
        var values = {};
        for(var key in graph.email) {
            var value = evaluate_formula(graph.email[key]);
            if(graph.email[key].length == 1 && graph.types[key] == 'f') {
                values[key] = sanitize_result(value, key);
            } else {
                values[key] = value;
            }
        }
        $.ajax(jzzf_ajax_url, {
            "data": {
                "form": form_id,
                "values": values,
                "action": "jzzf_email"
            },
            "error": function() { set_message(button, graph.form.email.fail); },
            "success": function(data) {
                if(data == "1") {
                    set_message(button, graph.form.email.ok);
                } else {
                    set_message(button, graph.form.email.fail);
                }
            }
        });
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
        if(id in just_updated) {
            return;
        }
        var value = evaluate(id);
        switch(graph.types[id]) {
            case 'f':
                element(id).val(sanitize_result(value, id));
                break;
            case 'm':
                if(value!==false) {
                    element(id).html(value);
                }
                break;
            case 't':
            case 'h':
                if(value!==false) {
                    element(id).text(value);
                }
                break;
        }
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
        if(!(id in cache) || !(id in just_updated)) {
            result = evaluation_worker(id);
            cache[id] = result;
        } else {
            result = cache[id];
        }
        return result;
    }
    
    function template(id) {
        var result = '';
        var chunks = graph.templates[id];
        if(chunks) {
            for(var i=0; i<chunks.length; i++) {
                var chunk = chunks[i];
                if(typeof chunk == 'object') {
                    if(is_formatted_variable(chunk)) {
                        result += evaluate_formatted_variable(chunk);
                    } else {
                        result += evaluate_formula(chunk);
                    }
                } else {
                    result += chunk;
                }
            }
            return result;
        }
        return false;
    }
    
    function is_formatted_variable(formula) {
        if(formula && formula.length == 1 && formula[0][0] == 'v') {
            return graph.types[formula[0][1]] == 'f';
        } else {
            return false;
        }
    }
    
    function evaluate_formatted_variable(formula) {
        var id = formula[0][1];
        return sanitize_result(evaluate(id), id);
    }
    
    function evaluation_worker(id) {
        switch(graph.types[id]) {
            case 'n':
                var input = element(id).val();
                if(id in graph.data) {
                    var factor = to_float_for_factor(graph.data[id]);
                    if(!isNaN(factor)) {
                        return input*factor;
                    } else {
                        return input;
                    }
                } else {
                    return input;
                }
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
            case 'm':
            case 't':
            case 'h':
                return template(id);
        }
        return 0;
    }
    
    function to_float_for_calculation(val) {
        return Number(val);
    }

    function to_float_for_factor(val) {
        if(typeof val == 'string' && val.match(/^\s*$/)) {
            return 1;
        } else {
            return Number(val);
        }
    }
    
    function formula(id) {
        var f = graph.formulas[id];
        if(!f) {
            return undefined;
        }
        return evaluate_formula(f);
    }
    
    function evaluate_formula(f) {
        var stack = [];
        for(var i=0; i<f.length; i++) {
            switch(f[i][0]) {
                case 'n':
                case 's':
                    stack.push(f[i][1]);
                    break;
                case 'v':
                    stack.push(evaluate(f[i][1]));
                    break;
                case 'o':
                    var right = to_float_for_calculation(stack.pop());
                    var left = to_float_for_calculation(stack.pop());
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

    function numarg(idx, def) {
        return Number(arg(idx, def));
    }

    var all = {
        'abs': function() {
            return Math.abs(numarg(0));
        },
        'round': function() {
            var digits = numarg(1, 0);
            var decimal = Math.pow(10, digits);
            return Math.round(numarg(0)*decimal)/decimal;
        },
        'mround': function() {
            var multiple = numarg(1);
            return Math.round(numarg(0)/multiple)*multiple;
        },
        'roundup': function() {
            var digits = numarg(1, 0);
            var decimal = Math.pow(10, digits);
            var x = numarg(0);
            return (x > 0) ? Math.ceil(numarg(0)*decimal)/decimal : Math.floor(numarg(0)*decimal)/decimal;
        },
        'rounddown': function() {
            var digits = numarg(1, 0);
            var decimal = Math.pow(10, digits);
            var x = numarg(0);
            return (x > 0) ? Math.floor(numarg(0)*decimal)/decimal : Math.ceil(numarg(0)*decimal)/decimal;
        },
        'ln': function() {
            var x = numarg(0);
            return Math.log(x);
        },
        'log': function() {
            var x = numarg(0);
            var b = numarg(1, 10);
            return Math.log(x) / Math.log(b);
        },
        'log10': function() {
            var x = numarg(0);
            return Math.log(x) / Math.log(10);
        },
        'exp': function() {
            var x = numarg(0);
            return Math.exp(x);
        },
        'power': function() {
            var x = numarg(0);
            var y = numarg(1);
            return Math.pow(x, y);
        },
        'sqrt': function() {
            return Math.sqrt(numarg(0));
        },
        'sin': function() {
            return Math.sin(numarg(0));
        },
        'cos': function() {
            return Math.cos(numarg(0));
        },
        'tan': function() {
            return Math.tan(numarg(0));
        },
        'asin': function() {
            return Math.asin(numarg(0));
        },
        'acos': function() {
            return Math.acos(numarg(0));
        },
        'atan': function() {
            return Math.atan(numarg(0));
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

function Jzzf_Reference(id, engine) { this.ref_id = id; this.engine = engine; }
Jzzf_Reference.prototype.value = function() { return new Jzzf_Value(this.engine.evaluate(this.ref_id)); }
Jzzf_Reference.prototype.text = function() { return this.value().text(); }
Jzzf_Reference.prototype.number = function() { return this.value().number(); }
Jzzf_Reference.prototype.bool = function() { return this.value().bool(); }
Jzzf_Reference.prototype.id = function() { return this.ref_id; }

function Jzzf_Value(value) { this.value = value; }
Jzzf_Value.prototype.text = function() {
    if(typeof this.value == 'boolean') {
        return this.value ? "TRUE" : "FALSE";
    }
    return String(this.value); }
Jzzf_Value.prototype.number = function() {
    var x = Number(this.value);
    if(isNaN(x)) {
        throw new Jzzf_Error(Jzzf_Error.VALUE);
    }
    return x;
}
Jzzf_Value.prototype.bool = function() {
    if(typeof this.value == 'string') {
        var trimmed = this.value.replace(/^\s\s*/, '').replace(/\s\s*$/, '').toUpperCase();
        if(trimmed == 'TRUE') {
            return true;
        } else if(trimmed == 'FALSE') {
            return false;
        }
    }
    return this.number() != 0;
}
Jzzf_Value.prototype.id = function() { throw new Jzzf_Error(Jzzf_Error.VALUE); }

function Jzzf_Error(code) { this.code = code; }
Jzzf_Error.NULL = 1;
Jzzf_Error.DIV0 = 2;
Jzzf_Error.VALUE = 3;
Jzzf_Error.REF = 4;
Jzzf_Error.NAME = 5;
Jzzf_Error.NUM = 6;
Jzzf_Error.NA = 7;
Jzzf_Error.GETTING_DATA = 8;
Jzzf_Error.prototype.toString = function() {
    var messages = {
        1: "#NULL!",
        2: "#DIV/0!",
        3: "#VALUE!",
        4: "#REF!",
        5: "#NAME?",
        6: "#NUM!",
        7: "#N/A",
        8: "#GETTING_DATA"
    };
    if(this.code in messages) {
        return messages[this.code];
    } else {
        return "#N/A";
    }
}

