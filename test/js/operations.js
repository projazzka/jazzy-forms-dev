$(document).ready(function(){

module("Operations");

var types = new Jzzf_Types();
var lib = new Jzzf_Library(types);
function op(name, left, right) { return lib.operation(name, types.value(left), types.value(right)); }
function numop(name, left, right) { return types.precise(op(name, left, right)); }

test("sum", function() {
  equal(numop("+", 10.123, -11), -0.877);
});

test("sum text", function() {
  raises(function() { op("+", "1k", "2"); }, Jzzf_Error, "#VALUE!");
});

test("product", function() {
  equal(numop("*", "10", 1.11), 11.1);
});

test("product text", function() {
  raises(function() { op("*", "one", "2"); }, Jzzf_Error, "#VALUE!");
});

test("division", function() {
  equal(numop("/", 50, 2), 25);
});

test("division by zero", function() {
  raises(function() { op("/", 5, 0); }, Jzzf_Error, "#DIV/0!");
});

test("division zero by zero", function() {
  raises(function() { op("/", 0, 0); }, Jzzf_Error, "#DIV/0!");
});

test("greater than", function() {
  equal(op(">", 100, 99.999), true);
});

test("less or equal", function() {
  equal(op("<=", 99.999, 99.999), true);
});

test("identity", function() {
  equal(op("=", 123, 123), true);
});

test("identity precision", function() {
  equal(op("=", 0.12345678911, 0.123456789), true);
});

});
