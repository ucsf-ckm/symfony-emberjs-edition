App.Category = DS.Model.extend({
  name: DS.attr('string'),
  products: DS.hasMany('Product')
});

App.Category.FIXTURES = [
  {
    id: 0,
    name: 'First Category'
  },
  {
    id: 1,
    name: 'Second Category'
  },
];
