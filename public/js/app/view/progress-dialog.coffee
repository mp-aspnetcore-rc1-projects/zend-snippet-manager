define (require)->

  require "lib/jquery"
  require "lib/jquery-ui"
  require "lib/underscore.min"
  require "lib/backbone.min"
  options = require "util/options"

  ProgressDialog = Backbone.View.extend # la vue du dialog de progression
    el:$(options.progressDialogId)
    attributes :
      class : "progress-dialog"
    tagName : "div"
    initialize:->
      _.bindAll(this,'render','open','close')
      @template = _.template $(options.progressDialogTemplateId).html()
      this.$el.dialog(options.defaultDialogOptions)
      this.$el.dialog("hide")
      this.model.on "change",this.render
    render:->
      @$el.html @template(@model.toJSON())
      @
    open:->
      this.$el.dialog('open')
    close:->
      this.$el.dialog('close')


