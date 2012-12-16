define(function(require) {
  var Logger, LoginForm, options;
  require("lib/jquery");
  require("util/plugin/jquery/serializetoarray");
  require("lib/jquery-ui");
  require("lib/underscore.min");
  require("lib/backbone.min");
  Logger = require("util/logger");
  options = require("util/options");
  return LoginForm = Backbone.View.extend({
    el: options.loginFormId,
    initialize: function() {
      var _this = this;
      _.bindAll(this, "render", "success");
      this.template = _.template($(options.loginFormTemplateId).html());
      this.model.on("change", this.render);
      this.$el.dialog(_.extend({
        buttons: {
          login: function(e) {
            var formDatas;
            formDatas = _this.$el.find("form").serializeToArray();
            _this.model.loginModel.clear();
            Logger.log("serializing");
            Logger.log(formDatas);
            return _this.model.loginModel.save(formDatas, {
              success: _this.success,
              error: _this.error
            });
          },
          reset: function(e) {
            return _this.$el.find("form").get(0).reset();
          }
        }
      }, options.defaultDialogOptions));
      return this.$el.dialog("option", {
        title: "Login"
      });
    },
    render: function() {
      this.$el.html(this.template(this.model.toJSON()));
      this.trigger("open:loginform");
      this.$el.dialog("option", "modal", true);
      this.$el.dialog("open");
      return this;
    },
    success: function(model, response) {
      if (response.success === false) {
        console.log("login failure");
        this.model.set(response);
        return this.trigger("login:failure");
      } else if (response.success === true) {
        this.trigger("login:success");
        return this.$el.dialog('close');
      } else {
        return false;
      }
    },
    error: function() {
      return alert("Error sending datas to the server");
    }
  });
});
