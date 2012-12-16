
define(function(require) {
  var App;
  App = {};
  App.options = require("util/options");
  App.Logger = require("util/logger");
  App.Model = require("model/model");
  App.View = require("view/view");
  App.Collection = require("collection/collection");
  return App;
});
