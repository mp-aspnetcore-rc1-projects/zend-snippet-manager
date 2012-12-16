define (require,exports,module)->

  options = require "util/options"
  Snippet = require "model/snippet"

  SnippetCollection = Backbone.Collection.extend
    uri_param : null
    model     : Snippet
    url       : ->
      options.getSnippetsUri(@uri_param)
    parse     :(response)->
      return response.snippets
      
