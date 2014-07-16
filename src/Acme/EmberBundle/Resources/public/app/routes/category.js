App.CategoryRoute = Ember.Route.extend({
    model: function(params) {
      return this.store.find('category', params.id);
  }
});
