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
