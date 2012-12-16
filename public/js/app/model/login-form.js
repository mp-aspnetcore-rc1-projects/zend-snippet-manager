
define(function(require, exports, module) {
  var Logger, LoginForm, LoginModel, LogoutModel, options;
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = require("util/options");
  Logger = require("util/logger");
  LoginModel = Backbone.Model.extend({
    url: function() {
      return options.getLoginFormUri();
    }
  });
  LogoutModel = Backbone.Model.extend({
    url: function() {
      return options.getLogoutUri();
    }
  });
  LoginForm = Backbone.Model.extend({
    initialize: function() {
      this.loginModel = new LoginModel();
      return this.logoutModel = new LogoutModel();
    },
    url: function() {
      return options.getLoginFormUri();
    }
  });
  return exports.LoginForm = LoginForm;
});
