moduleForModel('Category', 'Unit - Category Model', {
  // Specify the other units that are required for this test.
 needs: ['model:Product']
});

test("it exists", function(){
  ok(this.subject() instanceof App.Category);
});

test('#properties', function() {

  var category = this.subject(App.Category.FIXTURES[0]);

  equal(category.get('name'), 'First Category');
});
