
define(function(require) {
  var Help, Logger, options;
  options = require("util/options");
  Logger = require("util/logger");
  return Help = Backbone.View.extend({
    el: "#help",
    template: _.template($('#help-template').html()),
    initialize: function() {
      _.bindAll(this);
      this.$el.dialog(options.defaultDialogOptions);
      this.$el.dialog("option", "title", "Help");
      return this.on("open", this.open);
    },
    render: function() {
      Logger.log("render@Help");
      this.$el.html(this.template(this.model.toJSON()));
      return this;
    },
    open: function() {
      Logger.log("open@Help");
      return this.$el.dialog("open");
    }
  });
});
