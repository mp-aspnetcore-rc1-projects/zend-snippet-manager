
define(function(require) {
  var About, options;
  options = require("util/options");
  return About = Backbone.View.extend({
    el: "#about",
    template: _.template($("#about-template").html()),
    initialize: function() {
      _.bindAll(this);
      this.$el.dialog(_.extend({
        title: "About"
      }, options.defaultDialogOptions));
      return this.on("open", this.open);
    },
    render: function() {
      return this.$el.html(this.template(this.model.toJSON()));
    },
    open: function() {
      return this.$el.dialog("open");
    },
    close: function() {
      return this.$sel.dialog("close");
    }
  });
});
