moduleForModel('Product', 'Unit - Product Model', {
  // Specify the other units that are required for this test.
 needs: ['model:Category']
});

test("it exists", function(){
  ok(this.subject() instanceof App.Product);
});

test('#properties', function() {

  var product = this.subject(App.Product.FIXTURES[0]);

  equal(product.get('name'), 'First Product');
  equal(product.get('description'), 'First Product Description');
  equal(product.get('category'), 0);

});

test('#properties2', function() {

  var product = this.subject(App.Product.FIXTURES[1]);

  equal(product.get('name'), 'Second Product');
  equal(product.get('description'), 'Second Product Description');
  equal(product.get('category'), 0);

});
