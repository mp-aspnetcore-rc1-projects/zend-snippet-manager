define (require)->

  require "lib/jquery"
  require "lib/jquery-ui"
  require "lib/underscore.min"
  require "lib/backbone.min"
  options = require "util/options"
  Logger = require "util/logger"

  Head  = Backbone.View.extend # vue de l'ent�te
    events:
      "click #my-snippets-link"       : "mysnippetsclick"
      "click #new-snippet-link"       : "newsnippetclick"
      "click #favorite-snippets-link" : "favoritesnippetsclick"
      "submit #search-form"           : "search"
      "click #login-link"             : "login"
      "click #logout-link"            : "logout"
      "click #about-link"             : "about"
      "click #help-link"              : "help"
    el:$(options.appHeadId)

    
    initialize: ->
      _.bindAll this
      @template = _.template $(options.appHeadTemplate).html()
      @model.on("change",@render)

    render:->

      @$el.hide().html(@template @model.toJSON()).fadeIn()
      @$el.find("#search").autocomplete
        source : (request,response)=> # request : &term=terme_de_recherche ,
        #response est un callback qui prend le tableau de résultats en argument
          $.getJSON options.getSnippetsUri(),request,(datas)-> # mapper le resultat de la requete vers un object compatible avec l'autocomplete
            result = _.map datas.snippets,(snippet)->
              category = _.find datas.categories,(category)-> # trouver le nom de la catégorie
                category.id==snippet.category_id
              {label:"#{category.title} : #{snippet.title}",value:snippet.title,id:snippet.id,snippet}
            response(result)

        select : (event,ui)=>
          @trigger "select:autocomplete" , {snippets:[ui.item.snippet]}
          
        minLength:2
        
    mysnippetsclick:(e)->
      @trigger "click:mysnippets",{_key:"user_id",_value:@model.get("user_id")}

    newsnippetclick :(e)->
      @trigger "click:newsnippet"

    favoritesnippetsclick:(e)->
      @trigger "click:favoritesnippets",{_key:"show_favorites",_value:true}

    search:(event)->
      keyword = @$el.find("#search").val().trim()
      Logger.log "search",keyword
      @trigger("submit:searchform" , [{_key:"term",_value:keyword},{_key:"mode",_value:"global"}]) if keyword
      event.preventDefault
      return false

    login:(event)->
      Logger.log "login",event
      @trigger "click:login"
      event.preventDefault()
      return false
      
    logout:(event)->
      Logger.log "logout",event
      @trigger "click:logout","log out"
      event.preventDefault
      return false

    doLogout:->
      @logoutModel.save({success:logOutSuccess})

    about:->
      @trigger "click:about"

    help:->
      Logger.log "help@Head"
      @trigger "click:help"
      return false
