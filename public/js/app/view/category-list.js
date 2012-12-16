
define(function(require) {
  var CategoryList, Logger, options;
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = require("util/options");
  Logger = require("util/logger");
  return CategoryList = Backbone.View.extend({
    el: options.categoryViewId,
    events: {
      'click .category-item': 'onCategoryClick'
    },
    initialize: function() {
      this.template = _.template($(options.categoryListTemplateId).html());
      _.bindAll(this, 'render');
      this.model.on("change", this.render);
      return this;
    },
    render: function() {
      this.$el.html(this.template(this.model.toJSON()));
      return this;
    },
    onCategoryClick: function(e) {
      var category_id;
      Logger.log('click', e, e.target);
      category_id = e.target.getAttribute("data-id");
      if (this.model.get("category_id") !== category_id) {
        this.model.set("category_id", category_id);
        this.model.fetch(options.getSnippetsUri("/category_id/" + category_id));
        this.trigger("category:change", {
          _key: "category_id",
          _value: category_id
        });
      }
      e.preventDefault();
      return false;
    }
  });
});
