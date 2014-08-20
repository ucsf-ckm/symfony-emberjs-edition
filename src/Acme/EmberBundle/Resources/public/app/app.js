window.App = Ember.Application.create();

//Get the URL for the api from symonfy and then drop the leading slash
var apiurl = Routing.generate(
    'acme_api_apiinfo'
).substr(1);
App.ApplicationAdapter = DS.RESTAdapter.extend({
  namespace: apiurl
});
