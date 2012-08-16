$(document).ready(function(){

module("Maths");

var engine = new function() {
  this.evaluate = function(id) {
    return "jresig";
  }
}
var types = new Jzzf_Types(engine);
var lib = new Jzzf_Library(types);
function v(val) { return types.value(val); }

test("abs negative", function() {
  equal(lib.execute('abs', [v(-123.23)]), 123.23);
});

test("abs positive", function() {
  equal(lib.execute('abs', [types.value(0.123)]), 0.123);
});

test("abs zero", function() {
  equal(lib.execute('abs', [types.value(0)]), 0);
});

test("sqrt positive", function() {
  equal(lib.execute('sqrt', [v(16)]), 4);
});

test("sqrt negative", function() {
  try{
    var x = lib.execute('sqrt', [v(-1)]);
  } catch(e) {
    equal(e.toString(), "#NUM!");
  }
});

test("round pos", function() {
  equal(lib.execute('round', [v(4.4)]), 4);
});

test("round pos2", function() {
  equal(lib.execute('round', [v(4.5)]), 5);
});

test("round neg", function() {
  equal(lib.execute('round', [v(-4.4)]), -4);
});

test("round two digits", function() {
  equal(lib.execute('round', [v(5.9876), v(2)]), 5.99);
});

test("round hundreds", function() {
  equal(lib.execute('round', [v(59876), v( -2)]), 59900);
});

test("round up pos", function() {
  equal(lib.execute('roundup', [v(4.4)]), 5);
});

test("round up pos2", function() {
  equal(lib.execute('roundup', [v(4.5)]), 5);
});

test("round up neg", function() {
  equal(lib.execute('roundup', [v(-4.4)]), -5);
});

test("round up two digits", function() {
  equal(lib.execute('roundup', [v(5.9876), v(2)]), 5.99);
});

test("round up two digits 2", function() {
  equal(lib.execute('roundup', [v(5.1234), v(2)]), 5.13);
});

test("round up hundreds", function() {
  equal(lib.execute('roundup', [v(591234), v(-2)]), 591300);
});

test("round down pos", function() {
  equal(lib.execute('rounddown', [v(4.4)]), 4);
});

test("round down pos2", function() {
  equal(lib.execute('rounddown', [v(4.5)]), 4);
});

test("round down neg", function() {
  equal(lib.execute('rounddown', [v(-4.4)]), -4);
});

test("round down two digits", function() {
  equal(lib.execute('rounddown', [v(5.9876), v(2)]), 5.98);
});

test("round down two digits 2", function() {
  equal(lib.execute('rounddown', [v(5.1234), v(2)]), 5.12);
});

test("round down hundreds", function() {
  equal(lib.execute('rounddown', [v(591234), v(-2)]), 591200);
});

test("sin 90 asin", function() {
  equal(prcsn(lib.execute('sin', [v(0.5*Math.PI)])), 1);
});

test("sin 45", function() {
  equal(prcsn(lib.execute('sin', [v(0.25*Math.PI)])), 0.707106781);
});

test("sin 360", function() {
  equal(prcsn(lib.execute('sin', [v(2*Math.PI)])), 0);
});

test("pi", function() {
  equal(prcsn(lib.execute('pi', [])), 3.141592654);
});

test("cos 90", function() {
  equal(prcsn(lib.execute('cos', [v(0.5*Math.PI)])), 0);
});

test("cos 45", function() {
  equal(prcsn(lib.execute('cos', [v(0.25*Math.PI)])), 0.707106781);
});

test("cos 360", function() {
  equal(prcsn(lib.execute('cos', [v(2*Math.PI)])), 1);
});

test("tan 0", function() {
  equal(prcsn(lib.execute('tan', [v(0)])), 0);
});

test("tan 45", function() {
  equal(prcsn(lib.execute('tan', [v(0.25*Math.PI)])), 1);
});

test("tan 360", function() {
  equal(prcsn(lib.execute('tan', [v(2*Math.PI)])), 0);
});

test("asin 1", function() {
  equal(prcsn(lib.execute('asin', [v(1)])), prcsn(0.5*Math.PI));
});

test("asin 0.7071...", function() {
  equal(prcsn(lib.execute('asin', [v(0.7071067812)])), prcsn(0.25*Math.PI));
});

test("asin 0", function() {
  equal(prcsn(lib.execute('sin', [v(0)])), 0);
});

test("acos 0", function() {
  equal(prcsn(lib.execute('acos', [v(0)])), prcsn(0.5*Math.PI));
});

test("acos 0.7071...", function() {
  equal(prcsn(lib.execute('acos', [v(0.7071067812)])), prcsn(0.25*Math.PI));
});

test("acos 1", function() {
  equal(prcsn(lib.execute('acos', [v(1)])), 0);
});

module("Logical")

test("not true", function() {
  equal(lib.execute('not', [v(true)]), false);
});

test("not false", function() {
  equal(lib.execute('not', [v(false)]), true);
});

test("true and false", function() {
  equal(lib.execute('and', [v(true), v(false)]), false);
});

test("false and true", function() {
  equal(lib.execute('and', [v(false), v(true)]), false);
});

test("false and false", function() {
  equal(lib.execute('and', [v(false), v(false)]), false);
});

test("true and true", function() {
  equal(lib.execute('and', [v(true), v(true)]), true);
});

test("true or false", function() {
  equal(lib.execute('or', [v(true), v(false)]), true);
});

test("false or true", function() {
  equal(lib.execute('or', [v(false), v(true)]), true);
});

test("false or false", function() {
  equal(lib.execute('or', [v(false), v(false)]), false);
});

test("true or true", function() {
  equal(lib.execute('or', [v(true), v(true)]), true);
});

test("if true", function() {
  equal(lib.execute('if', [v(true), v(10), v(20)]), 10);
});

test("if false", function() {
  equal(lib.execute('if', [v(false), v(10), v(20)]), 20);
});

test("if true, no value for false", function() {
  equal(lib.execute('if', [v(true), v(10)]), 10);
});

test("if false, no value for false", function() {
  equal(lib.execute('if', [v(false), v(10)]), false);
});

test("true", function() {
  equal(lib.execute('true', []), true);
});

test("false", function() {
  equal(lib.execute('false', []), false);
});


test("ln(1)", function() {
  equal(lib.execute('ln', [v(1)]), 0);
});

test("log(1)", function() {
  equal(lib.execute('log', [v(1)]), 0);
});

test("log10(1)", function() {
  equal(lib.execute('log10', [v(1)]), 0);
});

test("log(1, 2)", function() {
  equal(lib.execute('log', [v(1), v(2)]), 0);
});

test("ln(e)", function() {
  equal(lib.execute('ln', [v(Math.exp(1))]), 1);
});

test("log(10)", function() {
  equal(lib.execute('log', [v(10)]), 1);
});

test("log10(10)", function() {
  equal(lib.execute('log10', [v(10)]), 1);
});

test("log(256, 2)", function() {
  equal(lib.execute('log', [v(256), v(2)]), 8);
});

test("exp(0)", function() {
  equal(lib.execute('exp', [v(0)]), 1);
});

test("exp(1)", function() {
  equal(lib.execute('exp', [v(1)]), Math.exp(1));
});

test("power(17, 0)", function() {
  equal(lib.execute('power', [v(17), v(0)]), 1);
});

test("power(2, 8)", function() {
  equal(lib.execute('power', [v(2), v(8)]), 256);
});

test("mround(0.2, 0.5)", function() {
  equal(lib.execute('mround', [v(0.2), v(0.5)]), 0);
});

test("mround(0.5, 0.5)", function() {
  equal(lib.execute('mround', [v(0.4), v(0.5)]), 0.5);
});

test("mround(0.6, 0.5)", function() {
  equal(lib.execute('mround', [v(0.6), v(0.5)]), 0.5);
});

test("mround(-0.2, 0.5)", function() {
  try {
    var x = lib.execute('mround', [v(-0.2), v(0.5)]);
  } catch(e) {
    equal(e.toString(), "#NUM!");
  }
});

test("mround(0.2, -0.5)", function() {
  try {
    var x = lib.execute('mround', [v(0.2), v(-0.5)]);
  } catch(e) {
    equal(e.toString(), "#NUM!");
  }
});

test("mround(-0.2, -0.5)", function() {
    equal(lib.execute('mround', [v(-0.2), v(-0.5)]), 0);
});

test("mround(-0.4, -0.5)", function() {
  equal(lib.execute('mround', [v(-0.4), v(-0.5)]), -0.5);
});

test("mround(-0.6, -0.5)", function() {
  equal(lib.execute('mround', [v(-0.6), v(-0.5)]), -0.5);
});

test("mround(-5, -5)", function() {
  equal(lib.execute('mround', [v(-5), v(-5)]), -5);
});

test("mround(-7, -5)", function() {
  equal(lib.execute('mround', [v(-8.5), v(-5)]), -10);
});

module("referencing");

test("formatted(number)", function() {
  var engine = new function() {
    this.formatted = function(id) {
      ok(id, "igor");
      return "$123.40";
    }
  }
  var lib = new Jzzf_Library(types, engine);
  equal(lib.execute('formatted', [types.reference("igor")]), "$123.40");
});

test("formatted(unknown)", function() {
  var engine = new function() {
    this.formatted = function(id) {
      ok(id, "unknown");
      types.raise_ref();
    }
  }
  var lib = new Jzzf_Library(types, engine);
  
  raises(function() {
    lib.execute('formatted', [types.reference("igor")]);
  }, Jzzf_Error);
});

test("label()", function() {
  var engine = new function() {
    this.label = function(id) {
      ok(id, "igor");
      return "apples";
    }
  }
  var lib = new Jzzf_Library(types, engine);
  equal(lib.execute('label', [types.reference("igor")]), "apples");
});

});

function prcsn(x) {
    return Math.round(x*1000000000)/1000000000;
}