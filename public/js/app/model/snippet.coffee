define (require,exports,module)->

  require "lib/underscore.min"
  require "lib/backbone.min"
  options = require "util/options"

  Snippet = Backbone.Model.extend # un model de snippet
    idAttribute : 'id'
    urlRoot : ->
      params = ""
      if @get("id")?
        params = "/id/#{@get('id')}"
      options.getSaveSnippetUri(params)

  exports.Snippet = Snippet
