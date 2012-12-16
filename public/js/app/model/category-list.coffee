define (require,exports,module)->

  require "lib/underscore.min"
  require "lib/backbone.min"
  options = require "util/options"

  CategoryList = Backbone.Model.extend
    idAttribute : "category_id"
    url         : ->
      if this.has('category_id')
        param = "/category_id/#{this.get("category_id")}"
      options.getCategoriesUri(param)

  exports.CategoryList = CategoryList
