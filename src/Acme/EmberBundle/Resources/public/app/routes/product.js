App.ProductRoute = Ember.Route.extend({
    model: function(params) {
      return this.store.find('product', params.id);
  }
});

App.ProductController = Ember.ObjectController.extend({
  isEditing: false,
  actions: {
      edit: function() {
        this.set('isEditing', true);
      },
      doneEditing: function() {
        this.set('isEditing', false);
        this.get('model').save();
      }
  }
});
