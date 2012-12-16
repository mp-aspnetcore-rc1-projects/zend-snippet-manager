define (require)->

  options = require "util/options"
  Logger  = require "util/logger"

  Help = Backbone.View.extend
    el : "#help"
    template : _.template($('#help-template').html())
    initialize : ->
      _.bindAll(this)
      this.$el.dialog( options.defaultDialogOptions )
      @$el.dialog "option","title","Help"
      @on "open",@open
    render:->
      Logger.log "render@Help"
      @$el.html @template(@model.toJSON())
      return this
    open:->
      Logger.log "open@Help"
      @$el.dialog("open")

