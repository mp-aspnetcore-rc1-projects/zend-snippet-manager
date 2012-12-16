define (require)->
  
  require "lib/jquery"
  require "util/plugin/jquery/serializetoarray"
  require "lib/jquery-ui"
  require "lib/underscore.min"
  require "lib/backbone.min"
  Logger = require "util/logger"
  options = require "util/options"

  LoginForm = Backbone.View.extend # la vue du formulaire de snippet
    el : options.loginFormId
  
    initialize : ->
      _.bindAll this,"render","success"
      @template = _.template $(options.loginFormTemplateId).html()
      @model.on "change" , @render
      this.$el.dialog _.extend {
        buttons :
          login : (e)=>
            formDatas =this.$el.find("form").serializeToArray()
            this.model.loginModel.clear()
            Logger.log "serializing"
            Logger.log formDatas
            this.model.loginModel.save(formDatas,{success:@success,error:@error})
          reset : (e)=>
            this.$el.find("form").get(0).reset()
      } , options.defaultDialogOptions

      this.$el.dialog("option",{title:"Login"})

    render : ->

      this.$el.html @template @model.toJSON()
      
      this.trigger("open:loginform")
      this.$el.dialog("option","modal",true)
      this.$el.dialog("open")

      return this
    success : (model,response)->
      if response.success == false
        console.log "login failure"
        @model.set(response) # REMPLACER le html du formulaire par le html du serveur
        @trigger("login:failure")
      else if response.success == true
        @trigger("login:success")
        @$el.dialog('close')
      else
        return false
    error:->
      alert("Error sending datas to the server")

 
