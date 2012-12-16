
define(function(require, exports, module) {
  var Snippet, SnippetCollection, options;
  options = require("util/options");
  Snippet = require("model/snippet");
  return SnippetCollection = Backbone.Collection.extend({
    uri_param: null,
    model: Snippet,
    url: function() {
      return options.getSnippetsUri(this.uri_param);
    },
    parse: function(response) {
      return response.snippets;
    }
  });
});
