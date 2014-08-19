App.ProductsRoute = Ember.Route.extend({
    model: function(params) {
      return this.store.find('product');
  }
});
