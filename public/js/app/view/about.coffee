define (require)->

  options = require "util/options"

  About = Backbone.View.extend

    el         : "#about"
    template   : _.template($("#about-template").html())

    initialize :->
      _.bindAll(this)
      this.$el.dialog( _.extend( { title : "About" } , options.defaultDialogOptions) )
      @on "open",@open
    render     :->
      @$el.html @template @model.toJSON()
    open       :->
      @$el.dialog("open")
    close      :->
      @$sel.dialog("close")
