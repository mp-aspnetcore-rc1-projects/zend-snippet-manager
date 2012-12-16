
define(function(require, exports, module) {
  var head, options;
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = require("util/options");
  head = Backbone.Model.extend({
    url: function() {
      return options.getUserMenuUri();
    }
  });
  return exports.head = head;
});
