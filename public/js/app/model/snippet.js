
define(function(require, exports, module) {
  var Snippet, options;
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = require("util/options");
  Snippet = Backbone.Model.extend({
    idAttribute: 'id',
    urlRoot: function() {
      var params;
      params = "";
      if (this.get("id") != null) params = "/id/" + (this.get('id'));
      return options.getSaveSnippetUri(params);
    }
  });
  return exports.Snippet = Snippet;
});
