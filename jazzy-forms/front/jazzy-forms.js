/*
    This file is part of the WordPress plugin "Jazzy Forms"
    Copyright (C) 2012 by Igor Prochazka. www.jazzyforms.com
    Jazzy Forms is licensed under the GNU General Public License, version 3.
*/

function jazzy_forms($, form_id, graph) {
    
    var all_ids = [];
    
    var cache = new Jzzf_Cache();
    var types = new Jzzf_Types(this);
    var library = new Jzzf_Library(types);
    var formatter = new Jzzf_Formatter(types, graph.types, graph.params);
    var calculator = new Jzzf_Calculator(this, types, library, formatter);
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
        update_all();
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
                        update_all();
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
            element(id).find('input:radio').bind('change', function() {
                change(element_id($(this).parents('.jzzf_radio')));
            });
            break;
        case 'n':
        case 'd':
        case 'r':
        case 'c':
            element(id).bind('change', function() {
                change(element_id($(this)));
            });
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
            values[key] = calculator.placeholder(graph.email[key]);
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
    
    function update(id) {
        switch(graph.types[id]) {
            case 'f':
                update_output(id);
                break;
            case 'm':
                update_template(id, true);
                break;
            case 't':
            case 'h':
                update_template(id, false);
                break;
        }
    }

    function update_output(id) {
        var result;
        try {
            var value = self.evaluate(id).value();
            result = formatter.format(id, value);
        } catch(err) {
            if(err instanceof Jzzf_Error) {
                result = err.toString();
            } else {
                throw(err);
            }
        }
        element(id).val(result);
    }

    function update_template(id, html) {
        if(graph.templates[id]) {
            var value = self.evaluate(id).text();
            if(html) {
                element(id).html(value);
            } else {
                element(id).text(value);
            }
        }
    }

    function update_text(id) {
        var value = self.evaluate(id).text();
    }
    
    function change(id) {
        var dependencies = graph.dependencies[id];
        if(dependencies) {
            cache.mark_dirty(dependencies);
            for(var idx=0; idx<dependencies.length; idx++) {
                update(dependencies[idx]);
            }
        }
    }
    
    function update_all() {
        cache.reset();
        for(var idx=0; idx<all_ids.length; idx++) {
            update(all_ids[idx]);
        }
    }
    
    this.evaluate = function(id) {
        var result = cache.get(id);
        if(result !== undefined) {
            return result;
        }
        try {
            result = this.evaluation_worker(id);
            cache.set(result);
        } catch(err) {
            if(err instanceof Jzzf_Error) {
                cache.set_error(err);
                result = err;
            }
            throw err;
        }
        return result;
    }
                
    this.evaluation_worker = function(id) {
        switch(graph.types[id]) {
            case 'n':
                var input = element(id).val();
                var result;
                if(id in graph.data) {
                    var factor = to_float_for_factor(graph.data[id]);
                    if(!isNaN(factor)) {
                        result = input*factor;
                    } else {
                        result = input;
                    }
                } else {
                    result = input;
                }
                return types.value(result);
            case 'r':
                var idx = element(id).find('input:checked').parent().index();
                var result;
                if(idx>=0) {
                    result = graph.data[id][idx];
                } else {
                    result = 0;
                }
                return types.value(result);
            case "c":
                return types.value(element(id).is(':checked') ? graph.data[id][1] : graph.data[id][0]);
            case 'd':
                var idx = element(id).find('option:selected').index();
                var result;
                if(idx>=0) {
                    result = graph.data[id][idx];
                } else {
                    result = 0;
                }
                return types.value(result);
            case 'f':
                return calculator.formula(graph.formulas[id]);
            case 'm':
            case 't':
            case 'h':
                var chunks = graph.templates[id];
                if(chunks) {
                    return types.value(calculator.template(chunks));
                } else {
                    return types.value("");
                }
        }
        return types.value("");
    }
    
    function to_float_for_factor(val) {
        if(typeof val == 'string' && val.match(/^\s*$/)) {
            return 1;
        } else {
            return Number(val);
        }
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
            return left.number() < right.number();
        },
        ">": function(left, right) {
            return left.number() > right.number();
        },
        "<>": function(left, right) {
            return left.number() != right.number();
        },
        "<=": function(left, right) {
            return left.number() <= right.number();
        },
        ">=": function(left, right) {
            return left.number() >= right.number();
        },
        "=": function(left, right) {
            return left.number() == right.number();
        },
        "&": function(left, right) {
            return left.text() + right.text();
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
    
    function to_text(x) {
        if (Math.abs(x) < 1.0) {
            var e = parseInt(x.toString().split('e-')[1]);
            if (e) {
                x *= Math.pow(10,e-1);
                x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
            }
        } else {
            var e = parseInt(x.toString().split('+')[1]);
            if (e > 20) {
                e -= 20;
                x /= Math.pow(10,e);
                x += (new Array(e+1)).join('0');
            }
        }
        return "" + x;
    }
    
    round();
    
    var str = to_text(input);
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

    var breadcrumbs = {};
    
    function place_breadcrumb(id) {
        if(id in breadcrumbs) {
            types.raise_ref();
        }
        breadcrumbs[id] = true;
    }
    
    function withdraw_breadcrumb(id) {
        delete breadcrumbs[id];
    }
    
    function wipe_away_breadcrumbs() {
        breadcrumbs = {};
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
    Value.prototype.value = function() { return this; }
    Value.prototype.is_numeric = function() {
        var x = Number(this.data);
        return !isNaN(x);
    }
    Value.prototype.is_reference = function() { return false; }

    function Reference(id) {
        this.ref_id = id;
    }
    Reference.prototype.value = function() {
        place_breadcrumb(this.ref_id);
        var val = engine.evaluate(this.ref_id);
        if(val === undefined) {
            wipe_away_breadcrumbs();
            types.raise_ref();
        }
        val = val.value();
        withdraw_breadcrumb(this.ref_id);
        return val;
    }
    Reference.prototype.raw = function() { return this.value().raw(); }
    Reference.prototype.text = function() { return this.value().text(); }
    Reference.prototype.number = function() { return this.value().number(); }
    Reference.prototype.precise_number = function() { return this.value().precise_number(); }
    Reference.prototype.bool = function() { return this.value().bool(); }
    Reference.prototype.id = function() { return this.ref_id; }
    Reference.prototype.is_numeric = function() { return this.value().is_numeric(); }
    Reference.prototype.is_reference = function() { return true; }
    
    this.value = function(val) { return new Value(val); }
    this.reference = function(id) { return new Reference(id); }
}

function Jzzf_Cache() {
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

function Jzzf_Formatter(types, element_types, params) {
    this.format = function(id, value) {
        if(element_types[id] != 'f') {
            return value.text();
        }
        if(value.is_numeric()) {
            return jzzf_format(value.number(), params[id]);
        } else {
            return value.text();
        }
    }
}

function Jzzf_Calculator(engine, types, library) {
    this.formula = function(f) {
        if(f === null) {
            types.raise_name();
        }
        if(f.length == 0) {
            return types.value("");
        }
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
                    if(left === undefined || right === undefined) {
                        types.raise_name();
                    }
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
        return stack.pop();
    }
    
    this.template = function(chunks) {
        var result = "";
        for(var i=0; i<chunks.length; i++) {
            var chunk = chunks[i];
            if(typeof chunk == 'object') {
                result += this.placeholder(chunk);
            } else {
                result += chunk;
            }
        }
        return result;
    }
    
    this.placeholder = function(formula) {
        try {
            return this.formula(formula).text();
        } catch(err) {
            if(err instanceof Jzzf_Error) {
                return err.toString();
            } else {
                throw(err);
            }
        }
    }    
}
