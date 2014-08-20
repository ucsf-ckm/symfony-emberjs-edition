App.ProductsController = Ember.ArrayController.extend({
  actions: {
    createProduct: function() {
      // Get the product title set by the "New Product" text field
      var name = this.get('newName');
      if (!name) { return false; }
      if (!name.trim()) { return; }

      // Create the new Product model
      var product = this.store.createRecord('product', {
        name: name,
        description: 'new description',
        price: 23.4
      });
      //get the category we are going to add
      var promise = this.store.find('category', 1);
      promise.then( function(category){
          product.set('category', category);
          product.save();
      })

      this.set('newName', '');

    }
  }
});
