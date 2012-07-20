$(document).ready(function(){

module("Get/Set");

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

module("Mark dirty");

test("mark dirty, single", function() {
  var dependencies = {};
  var cache = new Jzzf_Cache(dependencies);
  cache.set("a", 10);
  cache.set("b", 20);
  cache.mark_dirty("a");
  strictEqual(cache.get("a"), undefined);
  strictEqual(cache.get("b"), 20);
  equal(cache.get_dirty().length, 1);
  ok(cache.get_dirty().indexOf("a") >= 0);
});

module("Mark dirty");

test("mark dirty, dependencies", function() {
  var dependencies = {"a": ["b", "c", "d"]};
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
  equal(cache.get_dirty().length, 4);
  ok(cache.get_dirty().indexOf("a") >= 0);
  ok(cache.get_dirty().indexOf("b") >= 0);
  ok(cache.get_dirty().indexOf("c") >= 0);
  ok(cache.get_dirty().indexOf("d") >= 0);
});

});

