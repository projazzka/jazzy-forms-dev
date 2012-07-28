$(document).ready(function(){

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

module("Error");

test("err div/0", function() {
  var types = new Jzzf_Types();
  raises(function() { types.raise_div0(); }, Jzzf_Error, '#DIV/0!');
});

test("err name", function() {
  var types = new Jzzf_Types();
  raises(function() { types.raise_name(); }, Jzzf_Error, '#NAME?');
});

module("Conversion");

test("text to text", function() {
  var types = new Jzzf_Types();
  var val = types.value("123");
  strictEqual(val.text(), '123');
});

test("text to number", function() {
  var types = new Jzzf_Types();
  var val = types.value("12.3");

  strictEqual(val.number(), 12.3);
});

test("text to number, trailing characters", function() {
  var types = new Jzzf_Types();
  var val = types.value(("123k"));
  raises(function() { var num = val.number(); }, Jzzf_Error, "#VALUE!");
});

test("text to number, trailing space", function() {
  var types = new Jzzf_Types();
  var val = types.value(("123 "));

  strictEqual(val.number(), 123);
});

test("text to number, leading space", function() {
  var types = new Jzzf_Types();
  var val = types.value((" 123"));

  strictEqual(val.number(), 123);
});

test("text to number, negative", function() {
  var types = new Jzzf_Types();
  var val = types.value(("-123"));

  strictEqual(val.number(), -123);
});

test('"true" to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("true"));

  strictEqual(val.bool(), true);
});

test('"TRUE" to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("TRUE"));

  strictEqual(val.bool(), true);
});

test('"TRUE" (spaces and camel case) to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("  tRuE  "));

  strictEqual(val.bool(), true);
});

test('"false" to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("false"));

  strictEqual(val.bool(), false);
});

test('"FALSE" to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("TRUE"));

  strictEqual(val.bool(), true);
});

test('"false" (spaces and camel case) to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("  fAlSe "));

  strictEqual(val.bool(), false);
});

test('number string to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("  123 "));

  strictEqual(val.bool(), true);
});

test('zero string to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("  0 "));

  strictEqual(val.bool(), false);
});

test('empty string to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value((""));

  strictEqual(val.bool(), false);
});

test('space string to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("  "));

  strictEqual(val.bool(), false);
});

test('letters string to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value(("a"));

  raises(function() { var num = val.number(); }, Jzzf_Error, "#VALUE!");
});

test("number to text", function() {
  var types = new Jzzf_Types();
  var val = types.value((123.4));

  strictEqual(val.text(), '123.4');
});

test("number to number (float)", function() {
  var types = new Jzzf_Types();
  var val = types.value((0.3));

  strictEqual(val.number(), 0.3);
});

test("number to number (integer)", function() {
  var types = new Jzzf_Types();
  var val = types.value((3));

  strictEqual(val.number(), 3);
});

test("number to number (zero)", function() {
  var types = new Jzzf_Types();
  var val = types.value((0));

  strictEqual(val.number(), 0);
});

test('zero to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value((0));

  strictEqual(val.bool(), false);
});

test('one to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value((1));

  strictEqual(val.bool(), true);
});

test('negative to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value((-1));

  strictEqual(val.bool(), true);
});

test('true to text', function() {
  var types = new Jzzf_Types();
  var val = types.value((true));

  strictEqual(val.text(), "TRUE");
});

test('false to text', function() {
  var types = new Jzzf_Types();
  var val = types.value((false));

  strictEqual(val.text(), "FALSE");
});

test('false to number', function() {
  var types = new Jzzf_Types();
  var val = types.value((false));

  strictEqual(val.number(), 0);
});

test('true to number', function() {
  var types = new Jzzf_Types();
  var val = types.value((true));

  strictEqual(val.number(), 1);
});

test('false to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value((false));

  strictEqual(val.bool(), false);
});

test('true to bool', function() {
  var types = new Jzzf_Types();
  var val = types.value((true));

  strictEqual(val.bool(), true);
});

module("Reference");

test('unknown', function() {
  function Engine() {
    this.evaluate = function(id) {
        return undefined;
    }
  }
  var types = new Jzzf_Types(new Engine());
  var ref = types.reference("igor");
  raises(function() { var val = ref.number(); }, Jzzf_Error, "#REF!");
});

test('success', function() {
  function Engine() {
    var types = new Jzzf_Types();
    this.evaluate = function(id) {
        ok(id, "igor");
        return types.value(0.123);
    }
  }
  var types = new Jzzf_Types(new Engine());
  var ref = types.reference("igor");
  strictEqual(ref.bool(), true);
  strictEqual(ref.number(), 0.123);
  strictEqual(ref.text(), "0.123");
  strictEqual(ref.id(), "igor");
});

test('dereference value', function() {
  var types = new Jzzf_Types();
  var ref = types.value("whatever");
  raises(function() { var id = ref.id(); }, Jzzf_Error, "#VALUE!");
});

test('raw text', function() {
  var types = new Jzzf_Types();
  var val = types.value(("text"));

  strictEqual(val.raw(), "text");
});

test('raw number', function() {
  var types = new Jzzf_Types();
  var val = types.value((123));

  strictEqual(val.raw(), 123);
});

test('raw zero', function() {
  var types = new Jzzf_Types();
  var val = types.value((0));

  strictEqual(val.raw(), 0);
});

test('raw bool', function() {
  var types = new Jzzf_Types();
  var val = types.value((false));

  strictEqual(val.raw(), false);
});

test('raw ref text', function() {
  var engine = new mock_engine1({"id": "text"});
  var types = new Jzzf_Types(engine);
  var ref = types.reference("id", engine);
  strictEqual(ref.raw(), "text");
});

test('raw ref number', function() {
  var engine = new mock_engine1({"id": 123});
  var types = new Jzzf_Types(engine);
  var ref = types.reference("id", engine);
  strictEqual(ref.raw(), 123);
});

test('raw ref zero', function() {
  var engine = new mock_engine1({"id": 0});
  var types = new Jzzf_Types(engine);
  var ref = types.reference("id", engine);
  strictEqual(ref.raw(), 0);
});

test('raw ref bool', function() {
  var engine = new mock_engine1({"id": false});
  var types = new Jzzf_Types(engine);
  var ref = types.reference("id", engine);
  strictEqual(ref.raw(), false);
});

module("Precision");

test('max precision', function() {
  var types = new Jzzf_Types();
  var val = types.value(0.123456789);
  strictEqual(val.number(), 0.123456789);
  strictEqual(val.precise_number(), 0.123456789);
  strictEqual(val.text(), '0.123456789');
});

test('precision', function() {
  var types = new Jzzf_Types();
  var val = types.value(0.123456789111);
  strictEqual(val.number(), 0.123456789111);
  strictEqual(val.precise_number(), 0.123456789);
  strictEqual(val.text(), '0.123456789');
});


});
