App.CategoriesRoute = Ember.Route.extend({
    model: function(params) {
      return this.store.find('category');
  }
});
