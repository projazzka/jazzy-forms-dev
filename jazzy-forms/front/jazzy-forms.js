/*
    This file is part of the WordPress plugin "Jazzy Forms"
    Copyright (C) 2012 by Igor Prochazka. www.jazzyforms.com
    Jazzy Forms is licensed under the GNU General Public License, version 3.
*/

function jazzy_forms($, form_id, graph) {
    
    var all_ids = [];
    
    var cache = new Jzzf_Cache();
    var types = new Jzzf_Types(this);
    var library = new Jzzf_Library(types, this);
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
                        if(!validate()) {
                            return;
                        }
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
                        this.form.reset();
                        update_all();
                        return false;
                    });
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
        case 'a':
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
        if(!validate()) {
            return;
        }
        set_message(button, graph.form.email.sending);
        var values = {};
        for(var key in graph.email) {
            values[key] = calculator.placeholder(graph.email[key]);
        }
        var obj = $.ajax({
            "type": "POST",
            "url": jzzf_ajax_url,
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
    
    function add_element_error(id, msg) {
        var div = element(id).closest('.jzzf_element').addClass('jzzf_erroneous');
        if(msg) {
            div.find('.jzzf_error').show().text(msg);
        }
    }
    
    function set_form_error(msg) {
        if(msg) {
            $('.jzzf_form_' + form_id + ' .jzzf_form_error').text(msg).show();
        }
    }
    
    function reset_error_messages() {
        var form_selector = '.jzzf_form_' + form_id;
        $(form_selector + ' .jzzf_erroneous').removeClass('jzzf_erroneous');
        $(form_selector + ' .jzzf_error, ' + form_selector + ' .jzzf_form_error').empty().hide();
    }

    function validate() {
        var incomplete = false;
        reset_error_messages();
        for(var id in graph.required) {
            var valid;
            switch(graph.types[id]) {
                case 'n':
                case 'a':
                    valid = !(element(id).val() == false);
                    break;
                case 'r':
                    var valid = element(id).find('input:checked').parent().index() > 0;
                    break;
                case 'd':
                    var valid = element(id).find('option:selected').index() > 0;
                    break;
            }
            if(!valid) {
                add_element_error(id, graph.required[id]);
                incomplete = true;
            }
        }
        if(incomplete) {
            set_form_error(graph.form.incomplete);
        }
        return !incomplete;
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
            result = self.formatted(id);
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
            case 'a':
                var input = element(id).val();
                return types.value(input);
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
            default:
                types.raise_ref();
                break;
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
    
    this.formatted = function(id) {
        var value = self.evaluate(id).value();
        return formatter.format(id, value);
    }

    this.label = function(id) {
        var type = graph.types[id];
        switch(type) {
            case "d":
                return element(id).find('option:selected').text();
            case "r":
                return element(id).find('input:checked').siblings("label").text();
            case "c":
                var box = element(id);
                return box.is(':checked') ? box.siblings("label").text() : "";
            default:
                types.raise_ref();
        }
    }
    
    this.selected = function(id) {
        var type = graph.types[id];
        switch(type) {
            case "d":
                return element(id).find('option:selected').index() + 1;
            case "r":
                return element(id).find('input:checked').parent().index() + 1;
            case "c":
                return types.value(element(id).is(':checked')) ? 1 : 0;
            default:
                types.raise_ref();
        }
    }
    
    this.checked = function(id) {
        if(graph.types[id] != 'c') {
            types.raise_ref();
        }
        return element(id).is(':checked');
    }
    
}

function Jzzf_Library(types, engine) {
    
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

    function _id(args, def) {
        if(!args.length) {
            return _default(def);
        }
        return args.shift().id();
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
            if((x>0 && multiple<0) || (x<0 && multiple>0)) {
                types.raise_num();
            }
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
            
            if(x<=0) {
                types.raise_num();
            }
            return Math.log(x);
        },
        'log': function(args) {
            var x = _number(args);
            var b = _number(args, 10);
            if(x<=0 || b<=0) {
                types.raise_num();
            }
            if(b==1) {
                types.raise_div0();
            }
            return Math.log(x) / Math.log(b);
        },
        'log10': function(args) {
            var x = _number(args);
            if(x<=0) {
                types.raise_num();
            }
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
            if(x<0) {
                types.raise_num();
            }
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
            if(!args.length)
                return types.raise_na();
            while(args.length) {
                if(!args.pop().bool()) {
                    args.length = 0;
                    return false;
                }
            }
            return true;
        },
        'or': function(args) {
            if(!args.length)
                return types.raise_na();
            while(args.length) {
                if(args.pop().bool()) {
                    args.length = 0;
                    return true;
                }
            }
            return false;
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
        },
        'formatted': function(args) {
            var id = _id(args);
            return engine.formatted(id);
        },
        'label': function(args) {
            var id = _id(args);
            return engine.label(id);
        },
        'selected': function(args) {
            var id = _id(args);
            return engine.selected(id);
        },
        'checked': function(args) {
            var id = _id(args);
            return engine.checked(id);
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
            return left.precise_number() < right.precise_number();
        },
        ">": function(left, right) {
            return left.precise_number() > right.precise_number();
        },
        "<>": function(left, right) {
            return left.precise_number() != right.precise_number();
        },
        "<=": function(left, right) {
            return left.precise_number() <= right.precise_number();
        },
        ">=": function(left, right) {
            return left.precise_number() >= right.precise_number();
        },
        "=": function(left, right) {
            return left.precise_number() == right.precise_number();
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
    this.raise_na = function() { throw new Jzzf_Error("#N/A") };
    
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
        if(this.data === "") {
            return false;
        }
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
        var node_stack = [f];
        var arg_idx_stack = [0];
        var result_stack = [];
        while(node_stack.length) {
            var node = node_stack.pop();
            var arg_idx = arg_idx_stack.pop();
            var type = node[0];
            if(type == 'n' || type == 's') {
                result_stack.push(types.value(node[1]));
            } else if(type == 'v') {
                result_stack.push(types.reference(node[1]));
            } else if(type == 'o' || type == 'f') {
                if(arg_idx < node.length-2) {
                    if(node[1] == 'if') {
                        if(arg_idx == 0) {
                            node_stack.push(node);
                            arg_idx_stack.push(1);
                            node_stack.push(node[2]);
                            arg_idx_stack.push(0);                            
                        } else {
                            var condition = result_stack.pop();
                            if(condition.bool()) {
                                node_stack.push(node[3]);
                                arg_idx_stack.push(0);                         
                            } else {
                                if(node.length > 4) { 
                                    node_stack.push(node[4]);                                
                                    arg_idx_stack.push(0);                         
                                } else {
                                    result_stack.push(types.value(0));
                                }
                            }
                        }
                    } else {
                        node_stack.push(node);
                        arg_idx_stack.push(arg_idx+1);
                        node_stack.push(node[arg_idx+2]);
                        arg_idx_stack.push(0)
                    }
                } else {
                    var args = [];
                    var result;
                    for(var i=0; i<arg_idx; i++) {
                        args.unshift(result_stack.pop());
                    }
                    if(type == 'o') {
                        var left = args[0];
                        var right = args[1];
                        if(left === undefined || right === undefined) {
                            types.raise_name();
                        }
                        result = library.operation(node[1], left, right);
                    } else {
                        result = library.execute(node[1], args);
                    }
                    result_stack.push(types.value(result));
                }
            }
        }
        return result_stack.pop();
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

jQuery(function() {
    if (typeof(jzzf_forms) != "undefined") {
        for(var i=0; i<jzzf_forms.length; i++) {
            var instance = new jazzy_forms(jQuery, jzzf_forms[i].id, jzzf_forms[i].data);
        }
    }
});

