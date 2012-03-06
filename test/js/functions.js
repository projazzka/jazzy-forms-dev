$(document).ready(function(){

module("Maths");

test("abs negative", function() {
  equal(jzzf_functions('abs', [-123.23]), 123.23);
});

test("abs positive", function() {
  equal(jzzf_functions('abs', [0.123]), 0.123);
});

test("abs zero", function() {
  equal(jzzf_functions('abs', [0]), 0);
});

test("sqrt positive", function() {
  equal(jzzf_functions('sqrt', [16]), 4);
});

test("sqrt negative", function() {
  same(jzzf_functions('sqrt', [-1]), NaN);
});

test("round pos", function() {
  equal(jzzf_functions('round', [4.4]), 4);
});

test("round pos2", function() {
  equal(jzzf_functions('round', [4.5]), 5);
});

test("round neg", function() {
  equal(jzzf_functions('round', [-4.4]), -4);
});

test("round two digits", function() {
  equal(jzzf_functions('round', [5.9876, 2]), 5.99);
});

test("round hundreds", function() {
  equal(jzzf_functions('round', [59876, -2]), 59900);
});

test("round up pos", function() {
  equal(jzzf_functions('roundup', [4.4]), 5);
});

test("round up pos2", function() {
  equal(jzzf_functions('roundup', [4.5]), 5);
});

test("round up neg", function() {
  equal(jzzf_functions('roundup', [-4.4]), -5);
});

test("round up two digits", function() {
  equal(jzzf_functions('roundup', [5.9876, 2]), 5.99);
});

test("round up two digits 2", function() {
  equal(jzzf_functions('roundup', [5.1234, 2]), 5.13);
});

test("round up hundreds", function() {
  equal(jzzf_functions('roundup', [591234, -2]), 591300);
});

test("round down pos", function() {
  equal(jzzf_functions('rounddown', [4.4]), 4);
});

test("round down pos2", function() {
  equal(jzzf_functions('rounddown', [4.5]), 4);
});

test("round down neg", function() {
  equal(jzzf_functions('rounddown', [-4.4]), -4);
});

test("round down two digits", function() {
  equal(jzzf_functions('rounddown', [5.9876, 2]), 5.98);
});

test("round down two digits 2", function() {
  equal(jzzf_functions('rounddown', [5.1234, 2]), 5.12);
});

test("round down hundreds", function() {
  equal(jzzf_functions('rounddown', [591234, -2]), 591200);
});

test("sin 90 asin", function() {
  equal(prcsn(jzzf_functions('sin', [0.5*Math.PI])), 1);
});

test("sin 45", function() {
  equal(prcsn(jzzf_functions('sin', [0.25*Math.PI])), 0.707106781);
});

test("sin 360", function() {
  equal(prcsn(jzzf_functions('sin', [2*Math.PI])), 0);
});

test("pi", function() {
  equal(prcsn(jzzf_functions('pi', [])), 3.141592654);
});

test("cos 90", function() {
  equal(prcsn(jzzf_functions('cos', [0.5*Math.PI])), 0);
});

test("cos 45", function() {
  equal(prcsn(jzzf_functions('cos', [0.25*Math.PI])), 0.707106781);
});

test("cos 360", function() {
  equal(prcsn(jzzf_functions('cos', [2*Math.PI])), 1);
});

test("tan 0", function() {
  equal(prcsn(jzzf_functions('tan', [0])), 0);
});

test("tan 45", function() {
  equal(prcsn(jzzf_functions('tan', [0.25*Math.PI])), 1);
});

test("tan 360", function() {
  equal(prcsn(jzzf_functions('tan', [2*Math.PI])), 0);
});

test("asin 1", function() {
  equal(prcsn(jzzf_functions('asin', [1])), prcsn(0.5*Math.PI));
});

test("asin 0.7071...", function() {
  equal(prcsn(jzzf_functions('asin', [0.7071067812])), prcsn(0.25*Math.PI));
});

test("asin 0", function() {
  equal(prcsn(jzzf_functions('sin', [0])), 0);
});

test("acos 0", function() {
  equal(prcsn(jzzf_functions('acos', [0])), prcsn(0.5*Math.PI));
});

test("acos 0.7071...", function() {
  equal(prcsn(jzzf_functions('acos', [0.7071067812])), prcsn(0.25*Math.PI));
});

test("acos 1", function() {
  equal(prcsn(jzzf_functions('acos', [1])), 0);
});

module("Logical")

test("not true", function() {
  equal(jzzf_functions('not', [true]), false);
});

test("not false", function() {
  equal(jzzf_functions('not', [false]), true);
});

test("true and false", function() {
  equal(jzzf_functions('and', [true, false]), false);
});

test("false and true", function() {
  equal(jzzf_functions('and', [false, true]), false);
});

test("false and false", function() {
  equal(jzzf_functions('and', [false, false]), false);
});

test("true and true", function() {
  equal(jzzf_functions('and', [true, true]), true);
});

test("true or false", function() {
  equal(jzzf_functions('or', [true, false]), true);
});

test("false or true", function() {
  equal(jzzf_functions('or', [false, true]), true);
});

test("false or false", function() {
  equal(jzzf_functions('or', [false, false]), false);
});

test("true or true", function() {
  equal(jzzf_functions('or', [true, true]), true);
});

test("if true", function() {
  equal(jzzf_functions('if', [true, 10, 20]), 10);
});

test("if false", function() {
  equal(jzzf_functions('if', [false, 10, 20]), 20);
});

test("if true, no value for false", function() {
  equal(jzzf_functions('if', [true, 10]), 10);
});

test("if false, no value for false", function() {
  equal(jzzf_functions('if', [false, 10]), false);
});

test("true", function() {
  equal(jzzf_functions('true', []), true);
});

test("false", function() {
  equal(jzzf_functions('false', []), false);
});

});

function prcsn(x) {
    return Math.round(x*1000000000)/1000000000;
}