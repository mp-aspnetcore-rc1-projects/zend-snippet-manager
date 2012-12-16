define (require)->
  
  require "lib/jquery"
  require "lib/jquery-ui"
  require "lib/underscore.min"
  require "lib/backbone.min"
  Logger = require "util/logger"
  options = require "util/options"

  SnippetForm = Backbone.View.extend # la vue du formulaire de snippet
    el : options.snippetFormId
  
    initialize : ->
      _.bindAll this,"render","success"
      @template = _.template $(options.snippetFormTemplate).html()
      @model.on "change" , @render
      this.$el.dialog _.extend {
        buttons :
          save : (e)=>
            formDatas =this.$el.find("form").serializeToArray()
            this.model.snippetModel.clear()
            Logger.log "serializing"
            Logger.log formDatas
            this.model.snippetModel.save(formDatas,{success:@success,error:@error})
          reset : (e)=>
            this.$el.find("form").get(0).reset()
      } , options.defaultDialogOptions
    render : ->
      this.$el.html @template @model.toJSON()
      
      this.trigger("open:snippetform")
      this.$el.dialog("open")
      return this
    success : (model,response)->
      if response.success == false
        console.log "failure of creating new snippet"
        @model.set(response) # REMPLACER le html du formulaire par le html du serveur
        @trigger("save:failure")
      else if response.success == true
        @trigger("save:success")
        @$el.dialog('close')
    error:->
      alert("Error saving snippet")

 
