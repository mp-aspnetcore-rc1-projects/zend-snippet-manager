
define(function(require, exports, module) {
  var CategoryList, options;
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = require("util/options");
  CategoryList = Backbone.Model.extend({
    idAttribute: "category_id",
    url: function() {
      var param;
      if (this.has('category_id')) {
        param = "/category_id/" + (this.get("category_id"));
      }
      return options.getCategoriesUri(param);
    }
  });
  return exports.CategoryList = CategoryList;
});
