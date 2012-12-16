define (require,exports,module)->

  require "lib/underscore.min"
  require "lib/backbone.min"
  options = require "util/options"

  Root = Backbone.Model.extend()
