define (require)->

  require "lib/underscore.min"
  require "lib/backbone.min"
  Logger = require "util/logger"
  options= require "util/options"
  
  Root = Backbone.View.extend
    initialize:(params)->
      { @category_list_view,
      @snippet_form_view,
      @snippet_list_view,
      @app_head_view
      @progressDialog_view
      @login_form_view
      @about_view
      @help_view
      } = params
      Logger.log @category_list_view , @snippet_list_view

      _.bindAll(this) # lier toutes les m�thodes au context actuel

      # behaviours
      
      @model.on "change",this.render
      @category_list_view.on "category:change",this.loadSnippets
      @app_head_view.on "click:mysnippets",this.loadSnippets
      @app_head_view.on "click:newsnippet",this.showSnippetForm
      @app_head_view.on "click:favoritesnippets",this.loadSnippets
      @app_head_view.on "select:autocomplete",this.renderAutoCompleteResult
      @app_head_view.on "submit:searchform",this.loadSnippets
      @app_head_view.on "click:login",this.showLoginForm
      @app_head_view.on "click:logout",this.logout
      @app_head_view.on "click:about",this.about
      @app_head_view.on "click:help",this.help
      @snippet_form_view.on "open:snippetform",this.loadComplete
      @snippet_list_view.on "click:update",this.showSnippetForm
      @snippet_list_view.on "click:delete",this.deleteSnippet
      @snippet_list_view.on "click:favorite",this.toggleFavorite
      @snippet_form_view.on "save:success",this.savesSnippet

      @login_form_view.on "open:loginform",this.loadComplete # le chargement du formulaire de login est termin�
      @login_form_view.on "login:success",this.loginSuccess
      @app_head_view.model.fetch()
      @about_view.render()
      @help_view.render()

      @category_list_view.model.fetch {success:this.categoriesLoaded}
      @progressDialog_view.model.set "message","loading snippets..."
      this.loadStart()
      @loadSnippets()
      
    loadStart:(message)->
      if message
        @progressDialog_view.model.set("message",message)
      @progressDialog_view.open()

    loadComplete:->
      @progressDialog_view.close()

    renderAutoCompleteResult:(datas={})-> # EFFECTUER le rendu de la la list des snippets suivant le résultat de l'autocomplete
      @snippet_list_view.model.unset("subtitle")
      @snippet_list_view.model.set("snippets",datas.snippets)

    loadSnippets:(datas={})->
      if _.isArray(datas) # traiter chaque parametre du tableau
        params = ''
        _.each datas , (data)->
          if data._key and data._value
            params+="/#{data._key}/#{data._value}"
        @snippet_list_view.model.set("uri_param",params,{silent:true})
      else # datas est un objet
        if datas._key and datas._value
          @snippet_list_view.model.set("uri_param","/#{datas._key}/#{datas._value}",{silent:true})
        else if not datas._reload
          @snippet_list_view.model.set("uri_param",null,{silent:true})
      @loadStart("loading snippets...")
      @snippet_list_view.model.fetch {success:this.loadComplete}

    showSnippetForm:(datas={})->
      Logger.log "show snippet form"
      @loadStart("loading snippet form")
      #@snippet_form_view.model.unset("id")
      @snippet_form_view.model.set({"id":  if datas.id? then datas.id else "" },{silent:true})
      @snippet_form_view.model.fetch()

    deleteSnippet:(datas={})->
      Logger.log "delete",datas
      if confirm("Delete this snippet ?")==false then return
      if datas.id
        Logger.log "delete snippet #{datas.id}"
        @loadStart("Deleting snippet")
        snippet = new App.Model.Snippet({id:datas.id})
        snippet.destroy {success:this.snippetProcessed}

    snippetProcessed:->
      @snippet_list_view.model.fetch {success:@loadComplete}

    showLoginForm:->
      @loadStart("Loading login Form...")
      @login_form_view.model.fetch()

    loginSuccess:(e)->
      @app_head_view.model.fetch()
      @loadSnippets { _reload : true }

    logout:(datas)->
      @loadStart "log out..."
      @login_form_view.model.logoutModel.save null,{success:@logoutSuccess}

    logoutSuccess:(model,response)->
      Logger.log model,response,"logout complete"
      @loadComplete()
      if response.success == true
        window.location=""

    toggleFavorite:(datas)->
      @loadStart "Toggle favorite snippet..."
      $.getJSON options.getToggleFavoriteSnippetUri("/id/#{datas.id}") ,=>
        @loadComplete()
        @loadSnippets _reload:true

    about:->
      @about_view.trigger "open"

    help:->
      Logger.log "help@Root"
      @help_view.trigger "open"
