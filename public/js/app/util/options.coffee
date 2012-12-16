define (require,exports,module)->

  require("lib/underscore.min")
  require("lib/backbone.min")
  
  # options
  options = {}

  options.APPLICATION_VERSION = 0.1

  ########################
  # Backbone options
  ########################


  Backbone.emulateHTTP = true # utiliser POST � la place de put et delete
  Backbone.emulateJSON = true # utiliser l'encodage classique de formulaire

  ###########
  # Constants
  ###########
  
  options.SERVICE_URI          = ""
  options.API_URI              = "./api"
  options.GET_ALL_SNIPPETS_URI = "/getallsnippets"
  options.GET_SNIPPET_FORM_URI = "/getsnippetform"
  options.GET_CATEGORIES       = "/getcategories"
  options.CREATE_SNIPPET_URI   = "/createsnippet"
  options.UPDATE_SNIPPET_URI   = "/updatesnippet"
  options.SAVE_SNIPPET_URI     = "/savesnippet"
  options.USER_CREDENTIALS_URI = "/getusercredentials"
  options.USER_MENU_URI        = "/getusermenu"
  options.LOGIN_FORM_URI       = "/getloginform"
  options.LOGIN_URI            = "/login"
  options.LOGOUT_URI           = "/logout"
  options.JSON_FORMAT          = "/format/json"
  options.SEARCH_URI           = "/searchsnippet"
  options.TOGGLE_FAVORITE_URI  = "/togglefavoritesnippet"

  ###########
  # VARIABLES
  ###########
  
  options.viewModel          = {}
  options.application_model  = {}

  options.$target         = undefined
  options.$snippet_form   = undefined
  options.$login_form     = undefined
  options.$progressDialog = undefined
  options.$mySnippetsLink = undefined
  #templates
  options.snippetListTemplateId    = "#snippet-list-template"
  options.loginFormTemplateId      = "#login-form-template"
  options.categoryListTemplateId   = "#category-list-template"
  options.progressDialogTemplateId = '#progress-dialog-template'
  options.appHeadTemplate          = "#app-head-template"
  options.snippetFormTemplate      = "#snippet-form-template"
  #IDs
  options.appHeadId                   = "#app-head"
  options.loginFormId                 = "#login-form"
  options.snippetFormId               = "#snippet-form"
  options.progressDialogId            = "#progress-dialog"
  options.viewTemplateId              = "#view-template"
  options.containerViewId             = "#container"
  options.categoryViewId              = "#category-list"
  options.snippetViewId               = "#snippet-list"
  options.newSnippetLinkId            = "#new-snippet-link"
  options.mySnippetsLinkId            = "#my-snippets-link"
  #classes
  options.snippetListClass     = "snippet-list"
  options.updateSnippetClass   = "update-snippet"
  options.deleteSnippetClass   = "delete-snippet"
  options.favoriteSnippetClass = "favorite-snippet"
  options.dialgWidth           = null
  options.dialogHeight         = null
  options.dialogClass          = "dialog"
  options.defaultDialogOptions =
      modal: true
      stack:true
      dialogClass:options.dialogClass
      title:"Snippet"
      show:
        effect: 'drop'
        direction: "up"
      hide:
        effect: 'drop'
        direction:"down"
      width:600
      position : "center"
      autoOpen : false

  ###
  FONCTIONS
  ###

  # obtenir l'uri du optionsebservice
  options.getSnippetsUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.GET_ALL_SNIPPETS_URI+params+options.JSON_FORMAT
  #obtenir l'uri de login
  options.getLoginUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.LOGIN_URI+params+options.JSON_FORMAT
  #obtenir l'uri de logout
  options.getLogoutUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.LOGOUT_URI+params+options.JSON_FORMAT
  #obtenir le formulaire de snippet
  options.getSnippetFormUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.GET_SNIPPET_FORM_URI+params+options.JSON_FORMAT
  # creer un snippet
  options.getSaveSnippetUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.SAVE_SNIPPET_URI+params+options.JSON_FORMAT # creer un snippet
  options.getCreateSnippetUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.CREATE_SNIPPET_URI+params+options.JSON_FORMAT
  # obtenir des infos sur l'user
  options.getUserCredentialsUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.USER_CREDENTIALS_URI+params+options.JSON_FORMAT
  # mettre � jour le snippet
  options.getSnippetUpdateUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.UPDATE_SNIPPET_URI+params+options.JSON_FORMAT

  options.getUserMenuUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.USER_MENU_URI+params+options.JSON_FORMAT
    
  # obtenir les infos de recherche
  options.getSearchUri = (params='')->
   options.SERVICE_URI+options.API_URI+options.SEARCH_URI+params+options.JSON_FORMAT

  # obtenir les categories
  options.getCategoriesUri = (params='')->
    options.SERVICE_URI+options.API_URI+options.GET_CATEGORIES+params+options.JSON_FORMAT

  # obtenir l'url du formulaire de connexion
  options.getLoginFormUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.LOGIN_FORM_URI+params+options.JSON_FORMAT

  options.getLogoutUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.LOGOUT_URI+params+options.JSON_FORMAT
   

  options.getToggleFavoriteSnippetUri = (params="")->
    options.SERVICE_URI+options.API_URI+options.TOGGLE_FAVORITE_URI+params+options.JSON_FORMAT

  exports.options = options

