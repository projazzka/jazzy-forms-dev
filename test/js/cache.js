$(document).ready(function(){

module("Get/Set");

test("not found", function() {
  var cache = new Jzzf_Cache();
  strictEqual(cache.get("id"), undefined);
});

test("found", function() {
  var cache = new Jzzf_Cache();
  cache.set("a", 10);
  cache.set("b", 20);
  equal(cache.get("a"), 10);
  equal(cache.get("b"), 20);
});

module("Mark dirty");

test("mark dirty, single", function() {
  var cache = new Jzzf_Cache();
  cache.set("a", 10);
  cache.set("b", 20);
  cache.mark_dirty(["a"]);
  strictEqual(cache.get("a"), undefined);
  strictEqual(cache.get("b"), 20);
});

module("Mark dirty");

test("mark dirty, dependencies", function() {
  var cache = new Jzzf_Cache();
  cache.set("a", 10);
  cache.set("b", 20);
  cache.set("c", 30);
  cache.set("d", 40);
  cache.set("e", 50);
  cache.mark_dirty(["a", "b", "c", "d"]);
  strictEqual(cache.get("a"), undefined);
  strictEqual(cache.get("b"), undefined);
  strictEqual(cache.get("c"), undefined);
  strictEqual(cache.get("d"), undefined);
  strictEqual(cache.get("e"), 50);
});

module("Errors");

test("error", function() {
  var cache = new Jzzf_Cache();
  cache.set_error("a", new Jzzf_Error("#SOMEERROR!"));
  cache.set("b", 10);
  equal(cache.get("b"), 10);
  raises(function() { cache.get("a") }, Jzzf_Error, "#SOMEERROR!");
});


});

