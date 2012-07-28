$(document).ready(function(){

module("Formula");

function mock_engine1(map) {
    var types = new Jzzf_Types();
    this.evaluate = function(id) {
        var result = map[id];
        if(result === undefined) {
            throw new Jzzf_Error("#REF!");
        }
        return types.value(result);
    }
}
    
test("Arithmetic operation", function() {
    var types = new Jzzf_Types();
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var f = [['n', 10], ['n', 20], ['o', '+']];
    var result = calculator.formula(f);
    strictEqual(result.text(), '30');
    strictEqual(result.number(), 30);
});

test("Dereferencing", function() {
    var engine = new mock_engine1({"a": 10, "b": 20});
    var types = new Jzzf_Types(engine);
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator(engine, types, library);
    var f = [['v', "a"], ['v', "b"], ['o', '+']];
    var result = calculator.formula(f);
    strictEqual(result.text(), '30');
    strictEqual(result.number(), 30);
});

test("Dereferencing exception", function() {
    var engine = new mock_engine1({"a": 10});
    var types = new Jzzf_Types(engine);
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator(engine, types, library);
    var f = [['v', "a"], ['v', "b"], ['o', '+']];
    try {
        var result = calculator.formula(f);
        ok(false);
    } catch(err) {
        ok(err instanceof Jzzf_Error);
        equals(err.toString(), "#REF!");
    }
});

test("Missing operand", function() {
    var types = new Jzzf_Types();
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var f = [['n', 20], ['o', '+']];
    try {
        var result = calculator.formula(f);
        ok(false);
    } catch(err) {
        ok(err instanceof Jzzf_Error);
        equals(err.toString(), "#NAME?");
    }
});

test("Division by zero", function() {
    var types = new Jzzf_Types();
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var f = [['n', 20], ['n', '0'], ['o', '/']];
    try {
        var result = calculator.formula(f);
        ok(false);
    } catch(err) {
        ok(err instanceof Jzzf_Error);
        equals(err.toString(), "#DIV/0!");
    }
});

test("Number conversion exception", function() {
    var types = new Jzzf_Types();
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var f = [['s', "10k"], ['n', '0'], ['o', '+']];
    try {
        var result = calculator.formula(f);
        ok(false);
    } catch(err) {
        ok(err instanceof Jzzf_Error);
        equals(err.toString(), "#VALUE!");
    }
});

test("Function call, 1 argument", function() {
    var types = new Jzzf_Types();
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var f = [['n', 100], ['f', 'log', 1]];
    var result = calculator.formula(f);
    equals(result.number(), 2);
});

module("Placeholder");

test("Formula placeholder, single number", function() {
    var types = new Jzzf_Types();
    var library = new Jzzf_Library(types);
    var formatter = new function() {
        this.format = function(id, value) { ok(false); }
    }
    var calculator = new Jzzf_Calculator({}, types, library, formatter);
    var f = [['n', 100]];
    var result = calculator.placeholder(f);
    equals(result, "100");
});

test("Single string (formula)", function() {
    var types = new Jzzf_Types();
    var library = new Jzzf_Library(types);
    var formatter = new function() {
        this.format = function(id, value) { ok(false); }
    }
    var calculator = new Jzzf_Calculator({}, types, library, formatter);
    var f = [['s', '123']];
    var result = calculator.placeholder(f);
    equals(result, "123");
});

test("Division by zero", function() {
    var types = new Jzzf_Types();
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var f = [['n', 10], ['n', 0], ['o', '/']];
    var result = calculator.placeholder(f);
    equals(result, "#DIV/0!");
});

test("Single reference, propagated exception", function() {
    var engine = new function() {
        this.evaluate = function(id) {
            types.raise_name();
        }
    }
    var types = new Jzzf_Types(engine);
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator(engine, types, library);
    var f = [['v', 'unknown']];
    var result = calculator.placeholder(f);
    equals(result, "#NAME?");
});

test("Single reference", function() {
    var engine = new function() {
        this.evaluate = function(id) {
            equal(id, "igor");
            used_engine = true;
            return types.value(123);
        }
    }
    var types = new Jzzf_Types(engine);
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator(engine, types, library);
    var f = [['v', 'igor']];
    var result = calculator.placeholder(f);
    equals(result, "123");
});

module("Templates");

test("Empty", function() {
    var calculator = new Jzzf_Calculator();
    var result = calculator.template([]);
    strictEqual(result, "");
});

test("String only", function() {
    var calculator = new Jzzf_Calculator();
    var result = calculator.template(["text"]);
    strictEqual(result, "text");
});

test("Formula only", function() {
    var types = new Jzzf_Types({});
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var result = calculator.template([[["n", 10], ["n", 20], ["o", "+"]]]);
    strictEqual(result, "30");
});

test("String, formula", function() {
    var types = new Jzzf_Types({});
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var result = calculator.template(["10 + 20 = ", [["n", 10], ["n", 20], ["o", "+"]]]);
    strictEqual(result, "10 + 20 = 30");
});

test("Formula, string", function() {
    var types = new Jzzf_Types({});
    var library = new Jzzf_Library(types);
    var calculator = new Jzzf_Calculator({}, types, library);
    var result = calculator.template([[["s", "formula "]], "string"]);
    strictEqual(result, "formula string");
});

});
