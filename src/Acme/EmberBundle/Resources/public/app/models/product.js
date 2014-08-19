App.Product = DS.Model.extend({
  name: DS.attr('string'),
  description: DS.attr('string'),
  price: DS.attr('number'),
  category: DS.belongsTo('Category')
});

App.Product.FIXTURES = [
  {
    id: 0,
    name: 'First Product',
    description: 'First Product Description',
    price: 22.3,
    category: 0
  },
  {
    id: 1,
    name: 'Second Product',
    description: 'Second Product Description',
    price: 11.2,
    category: 0
  },
];
