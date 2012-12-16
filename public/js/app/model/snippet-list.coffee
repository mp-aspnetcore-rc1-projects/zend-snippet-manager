define (require,exports,module)->

  require "lib/underscore.min"
  require "lib/backbone.min"
  options = require "util/options"
  SnippetCollection = require "collection/snippet-collection"

  SnippetList = Backbone.Model.extend
    snippetCollection  : new SnippetCollection()
    idAttribute        : "category_id"
    url                : ->
      if @has("uri_param")
        param = @get("uri_param")
      options.getSnippetsUri(param)

  exports.SnippetList = SnippetList
