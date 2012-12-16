define (require,exports,module)->


  options = require "util/options"
  Snippet = require "model/snippet"

  SnippetForm = Backbone.Model.extend #un model de formulaire de snippet
    snippetModel : new Snippet()
    urlRoot : ->
      params = ""
      if @get(@idAttribute)?
        params = "/id/#{@get(@idAttribute)}"
      options.getSnippetFormUri(params)
