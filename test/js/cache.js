$(document).ready(function(){

module("Maths");

test("not found", function() {
  var dependencies = {};
  var cache = new Jzzf_Cache(dependencies);
  strictEqual(cache.get("id"), undefined);
});

test("found", function() {
  var dependencies = {};
  var cache = new Jzzf_Cache(dependencies);
  cache.set("a", 10);
  cache.set("b", 20);
  equal(cache.get("a"), 10);
  equal(cache.get("b"), 20);
});

test("mark dirty, single", function() {
  var dependencies = {};
  var cache = new Jzzf_Cache(dependencies);
  cache.set("a", 10);
  cache.set("b", 20);
  cache.mark_dirty("a");
  strictEqual(cache.get("a"), undefined);
  strictEqual(cache.get("b"), 20);
});

test("mark dirty, recursive dependency", function() {
  var dependencies = {"a": ["b", "c"], "c": ["d"]};
  var cache = new Jzzf_Cache(dependencies);
  cache.set("a", 10);
  cache.set("b", 20);
  cache.set("c", 30);
  cache.set("d", 40);
  cache.set("e", 50);
  cache.mark_dirty("a");
  strictEqual(cache.get("a"), undefined);
  strictEqual(cache.get("b"), undefined);
  strictEqual(cache.get("c"), undefined);
  strictEqual(cache.get("d"), undefined);
  strictEqual(cache.get("e"), 50);
});

});

