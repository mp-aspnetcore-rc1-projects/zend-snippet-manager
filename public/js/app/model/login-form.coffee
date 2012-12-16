define (require,exports,module)->

  require "lib/underscore.min"
  require "lib/backbone.min"
  options = require "util/options"
  Logger  = require "util/logger"

  LoginModel = Backbone.Model.extend
    url:->
      options.getLoginFormUri()

  LogoutModel = Backbone.Model.extend
    url:->
      options.getLogoutUri()

  LoginForm = Backbone.Model.extend

    initialize:->
      @loginModel = new LoginModel()
      @logoutModel = new LogoutModel()
          
    url : ->
      options.getLoginFormUri()

  exports.LoginForm = LoginForm
