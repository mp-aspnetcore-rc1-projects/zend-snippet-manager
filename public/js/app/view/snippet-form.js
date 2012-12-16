
define(function(require) {
  var Logger, SnippetForm, options;
  require("lib/jquery");
  require("lib/jquery-ui");
  require("lib/underscore.min");
  require("lib/backbone.min");
  Logger = require("util/logger");
  options = require("util/options");
  return SnippetForm = Backbone.View.extend({
    el: options.snippetFormId,
    initialize: function() {
      var _this = this;
      _.bindAll(this, "render", "success");
      this.template = _.template($(options.snippetFormTemplate).html());
      this.model.on("change", this.render);
      return this.$el.dialog(_.extend({
        buttons: {
          save: function(e) {
            var formDatas;
            formDatas = _this.$el.find("form").serializeToArray();
            _this.model.snippetModel.clear();
            Logger.log("serializing");
            Logger.log(formDatas);
            return _this.model.snippetModel.save(formDatas, {
              success: _this.success,
              error: _this.error
            });
          },
          reset: function(e) {
            return _this.$el.find("form").get(0).reset();
          }
        }
      }, options.defaultDialogOptions));
    },
    render: function() {
      this.$el.html(this.template(this.model.toJSON()));
      this.trigger("open:snippetform");
      this.$el.dialog("open");
      return this;
    },
    success: function(model, response) {
      if (response.success === false) {
        console.log("failure of creating new snippet");
        this.model.set(response);
        return this.trigger("save:failure");
      } else if (response.success === true) {
        this.trigger("save:success");
        return this.$el.dialog('close');
      }
    },
    error: function() {
      return alert("Error saving snippet");
    }
  });
});
