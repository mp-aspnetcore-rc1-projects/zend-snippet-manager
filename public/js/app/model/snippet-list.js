
define(function(require, exports, module) {
  var SnippetCollection, SnippetList, options;
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = require("util/options");
  SnippetCollection = require("collection/snippet-collection");
  SnippetList = Backbone.Model.extend({
    snippetCollection: new SnippetCollection(),
    idAttribute: "category_id",
    url: function() {
      var param;
      if (this.has("uri_param")) param = this.get("uri_param");
      return options.getSnippetsUri(param);
    }
  });
  return exports.SnippetList = SnippetList;
});
