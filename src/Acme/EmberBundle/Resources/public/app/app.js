window.App = Ember.Application.create();

//Get the URL for the api from symonfy and then drop the leading slash
var apiurl = Routing.generate(
    'acme_api_apiinfo'
).substr(1);
App.ApplicationAdapter = DS.RESTAdapter.extend({
  namespace: apiurl
});

App.Product = DS.Model.extend({
  name: DS.attr('string'),
  description: DS.attr('string'),
  price: DS.attr('number'),
  category: DS.belongsTo('Category')
});

App.Category = DS.Model.extend({
  name: DS.attr('string'),
  products: DS.hasMany('Product')
});

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
