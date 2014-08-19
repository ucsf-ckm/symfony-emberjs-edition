App.Router = Ember.Router.extend({
    location: 'hash'
});

App.Router.map(function() {
    this.route("index", {path: "/"});
    this.resource('categories', function() {
        this.resource('category', { path: ':id' });
    });
    this.resource('products', function() {
        this.resource('product', { path: ':id' });
    });
});
