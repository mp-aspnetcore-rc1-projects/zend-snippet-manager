
define(function(require, exports, module) {
  var Snippet, SnippetForm, options;
  options = require("util/options");
  Snippet = require("model/snippet");
  return SnippetForm = Backbone.Model.extend({
    snippetModel: new Snippet(),
    urlRoot: function() {
      var params;
      params = "";
      if (this.get(this.idAttribute) != null) {
        params = "/id/" + (this.get(this.idAttribute));
      }
      return options.getSnippetFormUri(params);
    }
  });
});
