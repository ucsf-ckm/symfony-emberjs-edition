module('Acceptances - Index', {
  setup: function(){
    App.reset();
  },
  teardown: function() {
    Ember.run(App, 'destroy');
  }
});

test('index renders', function(){
  expect(3);

  visit('/').then(function(){
    var title = find('h1');
    var list = find('nav a');

    equal(title.text(), 'Home');

    equal(list.length, 3);
    equal(list.text(), 'HomeCategoriesProducts');
  });
});
