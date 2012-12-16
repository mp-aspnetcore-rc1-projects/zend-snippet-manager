define (require,exports,module)->
  
  require "lib/underscore.min"
  require "lib/backbone.min"
  options = require "util/options"

  head = Backbone.Model.extend
    url:->
      options.getUserMenuUri()

  exports.head = head

