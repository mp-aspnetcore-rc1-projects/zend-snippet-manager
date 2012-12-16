
define(function(require) {
  var ProgressDialog, options;
  require("lib/jquery");
  require("lib/jquery-ui");
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = require("util/options");
  return ProgressDialog = Backbone.View.extend({
    el: $(options.progressDialogId),
    attributes: {
      "class": "progress-dialog"
    },
    tagName: "div",
    initialize: function() {
      _.bindAll(this, 'render', 'open', 'close');
      this.template = _.template($(options.progressDialogTemplateId).html());
      this.$el.dialog(options.defaultDialogOptions);
      this.$el.dialog("hide");
      return this.model.on("change", this.render);
    },
    render: function() {
      this.$el.html(this.template(this.model.toJSON()));
      return this;
    },
    open: function() {
      return this.$el.dialog('open');
    },
    close: function() {
      return this.$el.dialog('close');
    }
  });
});
