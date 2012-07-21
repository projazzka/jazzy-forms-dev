/*
    This file is part of the WordPress plugin "Jazzy Forms"
    Copyright (C) 2012 by Igor Prochazka. www.jazzyforms.com
    Jazzy Forms is licensed under the GNU General Public License, version 3.
*/

function jazzy_forms($, form_id, graph) {
    
    var all_ids = [];
    var cache = {};
    
    var types = new Jzzf_Types(this);
    var library = new Jzzf_Library(types);
    
    var self = this;
    
    jzzf_precision = Math.pow(10,9);
    function prcsn(x) {
        return Math.round(x*jzzf_precision)/jzzf_precision;
    }
    
    function retrieve_all_ids() {
        for(id in graph.types) {
            all_ids.push(id);
        }
    }
    
    $(function(args) {
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
        var value = self.evaluate(id);
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
    
    this.evaluate = function(id) {
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
        return sanitize_result(self.evaluate(id), id);
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
                    stack.push(types.value(f[i][1]));
                    break;
                case 'v':
                    stack.push(types.reference(f[i][1]));
                    break;
                case 'o':
                    var right = stack.pop();
                    var left = stack.pop();
                    var result = library.operation(f[i][1], left, right);
                    stack.push(types.value(result));
                    break;
                case 'f':
                    var args=[];
                    for(var j=0; j<f[i][2]; j++) {
                        args.unshift(stack.pop());
                    }
                    stack.push(types.value(library.execute(f[i][1], args)));
                    break;
            }
        }
        return stack.pop().number();
    }
    
}

function Jzzf_Library(types) {
    
    function _default(def) {
        if(def === undefined) {
            types.raise_name();
        }
        return def;
    }
    
    function _number(args, def) {
        if(!args.length) {
            return _default(def);
        }
        return args.shift().number();
    }

    function _bool(args, def) {
        if(!args.length) {
            return _default(def);
        }
        return args.shift().bool();
    }

    function _raw(args, def) {
        if(!args.length) {
            return _default(def);
        }
        return args.shift().raw(args);
    }
    
    var functions = {
        'abs': function(args) {
            var x = _number(args);
            return Math.abs(x);
        },
        'round': function(args) {
            var x = _number(args);
            var digits = _number(args, 0);
            
            var decimal = Math.pow(10, digits);
            return Math.round(x*decimal)/decimal;
        },
        'mround': function(args) {
            var x = _number(args);
            var multiple = _number(args);
            
            return Math.round(x/multiple)*multiple;
        },
        'roundup': function(args) {
            var x = _number(args);
            var digits = _number(args, 0);
            
            var decimal = Math.pow(10, digits);
            return (x > 0) ? Math.ceil(x*decimal)/decimal : Math.floor(x*decimal)/decimal;
        },
        'rounddown': function(args) {
            var x = _number(args);
            var digits = _number(args, 0);
            
            var decimal = Math.pow(10, digits);
            return (x > 0) ? Math.floor(x*decimal)/decimal : Math.ceil(x*decimal)/decimal;
        },
        'ln': function(args) {
            var x = _number(args);
            
            return Math.log(x);
        },
        'log': function(args) {
            var x = _number(args);
            var b = _number(args, 10);
            return Math.log(x) / Math.log(b);
        },
        'log10': function(args) {
            var x = _number(args);
            return Math.log(x) / Math.log(10);
        },
        'exp': function(args) {
            var x = _number(args);
            return Math.exp(x);
        },
        'power': function(args) {
            var x = _number(args);
            var y = _number(args);
            return Math.pow(x, y);
        },
        'sqrt': function(args) {
            var x = _number(args);
            return Math.sqrt(x);
        },
        'sin': function(args) {
            var x = _number(args);
            return Math.sin(x);
        },
        'cos': function(args) {
            var x = _number(args);
            return Math.cos(x);
        },
        'tan': function(args) {
            var x = _number(args);
            return Math.tan(x);
        },
        'asin': function(args) {
            var x = _number(args);
            return Math.asin(x);
        },
        'acos': function(args) {
            var x = _number(args);
            return Math.acos(x);
        },
        'atan': function(args) {
            var x = _number(args);
            return Math.atan(x);
        },
        'pi': function(args) {
            return Math.PI;
        },
        'not': function(args) {
            var e = _bool(args);
            return !e;
        },
        'and': function(args) {
            var e = _bool(args);
            var f = _bool(args);
            return e && f;
        },
        'or': function(args) {
            var e = _bool(args);
            var f = _bool(args);
            return e || f;
        },
        'if': function(args) {
            var c = _bool(args);
            var y = _raw(args, 0);
            var n = _raw(args, 0);
            return c ? y : n;
        },
        'true': function(args) {
            return true;
        },
        'false': function(args) {
            return false;
        }
        
    };
    
    var operations = {
        "+": function(left, right) {
            return left.number() + right.number();
        },
        "-": function(left, right) {
            return left.number() - right.number();
        },
        "*": function(left, right) {
            return left.number() * right.number();
        },
        "/": function(left, right) {
            var divisor = right.number();
            if(divisor == 0) {
                types.raise_div0();
            }
            return left.number() / right.number();
        },
        "^": function(left, right) {
            return Math.pow(left.number(), right.number());
        },
        "<": function(left, right) {
            return prcsn(left.number()) < prcsn(right.number());
        },
        ">": function(left, right) {
            return prcsn(left.number()) > prcsn(right.number());
        },
        "<>": function(left, right) {
            return prcsn(left.number()) != prcsn(right.number());
        },
        "<=": function(left, right) {
            return prcsn(left.number()) <= prcsn(right.number());
        },
        ">=": function(left, right) {
            return prcsn(left.number()) >= prcsn(right.number());
        },
        "=": function(left, right) {
            return prcsn(left.number()) == prcsn(right.number());
        }
    }

    this.execute = function(name, args) {
        if(!(name in functions)) {
            types.raise_name();
        }
        var result = functions[name](args);
        
        if(args.length) {
            types.raise_name();
        }
        return result;
    }
    
    this.operation = function(name, left, right) {
        if(!(name in operations)) {
            types.raise_name();
        }
        return operations[name](left, right);
    }
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

function Jzzf_Error(code) {
    this.code = code;
    this.toString = function() { return this.code; }
}

function Jzzf_Types(engine) {
    var types = this;
    
    this.raise_null = function() { throw new Jzzf_Error("#NULL!") };
    this.raise_div0 = function() { throw new Jzzf_Error("#DIV/0!") };
    this.raise_value = function() { throw new Jzzf_Error("#VALUE!") };
    this.raise_ref = function() { throw new Jzzf_Error("#REF!"); };
    this.raise_name = function() { throw new Jzzf_Error("#NAME?"); };
    this.raise_num = function() { throw new Jzzf_Error("#NUM!"); };
    this.raise_na = function() { throw new Jzzf_Error("#N/A!") };
    
    var precision = Math.pow(10,9);

    this.precise = function(x) {
        return Math.round(x*precision)/precision;
    }

    function Value(data) { this.data = data; }
    Value.prototype.text = function() {
        if(typeof this.data == 'boolean') {
            return this.data ? "TRUE" : "FALSE";
        } else if(typeof this.data == 'number') {
            return String(types.precise(this.data));
        }
        return String(this.data);
    }
    Value.prototype.number = function() {
        var x = Number(this.data);
        if(isNaN(x)) {
            types.raise_value();
        }
        return x;
    }
    Value.prototype.precise_number = function() {
        return types.precise(this.number());
    }

    Value.prototype.bool = function() {
        if(typeof this.data == 'string') {
            var trimmed = this.data.replace(/^\s\s*/, '').replace(/\s\s*$/, '').toUpperCase();
            if(trimmed == 'TRUE') {
                return true;
            } else if(trimmed == 'FALSE') {
                return false;
            }
        }
        return this.number() != 0;
    }
    Value.prototype.id = function() { types.raise_value(); }
    Value.prototype.raw = function() { return this.data; }

    function Reference(id) {
        this.ref_id = id;
    }
    Reference.prototype.raw = function() {
        var val = engine.evaluate(this.ref_id);
        if(val === undefined) {
            types.raise_ref();
        }
        return val;
    }
    Reference.prototype.value = function() { return types.value(this.raw()); }
    Reference.prototype.text = function() { return this.value().text(); }
    Reference.prototype.number = function() { return this.value().number(); }
    Reference.prototype.precise_number = function() { return this.value().precise_number(); }
    Reference.prototype.bool = function() { return this.value().bool(); }
    Reference.prototype.id = function() { return this.ref_id; }
    
    this.value = function(val) { return new Value(val); }
    this.reference = function(id) { return new Reference(id); }
}

function Jzzf_Cache(dependencies) {
    var data = {};
    var errors = {};
    
    this.get = function(id) {
        var result = data[id];
        if(result === null) {
            var error = errors[id];
            if(error) {
                throw error;
            }
        }
        return result;
    }
    
    this.set = function(id, value) {
        data[id] = value;
        delete errors[id];
    }
    
    this.set_error = function(id, err) {
        data[id] = null;
        errors[id] = err;
    }
    
    this.mark_dirty = function(ids) {
        for(var idx=0; idx<ids.length; idx++) {
            delete data[ids[idx]];
            delete errors[ids[idx]];
        }
    }
    
    this.reset = function() {
        data = {};
        errors = {};
    }
    
}
