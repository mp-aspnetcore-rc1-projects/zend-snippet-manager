define (require)->

  require "lib/jquery"
  require "lib/jquery-ui"
  require "lib/underscore.min"
  require "lib/backbone.min"
  require "lib/prettify"
  options = require "util/options"
  Logger = require "util/logger"

  SnippetList = Backbone.View.extend
    tagName    : "div"
    attributes :
      class : options.snippetListClass
      sty:e : "background:#EEE"
    className  : options.snippetListClass
    el         : options.snippetViewId
    template   :  _.template $(options.snippetListTemplateId).html()
    events     :
      "click .snippet-head"      : "toggleSnippetContent"
      "click .favorite-snippet"  : "toggleFavorite"
      "click .update-snippet"    : "updateSnippet"
      "click .delete-snippet"    : "deleteSnippet"
    initialize : ->
      _.bindAll this
      this.model.on("change",this.render)
    render     : ->
      Logger.log "rendering snippet list"
      @$el.hide()
      @$el.html(@template @model.toJSON())
      prettyPrint()
      this.$(".snippet-content").hide()
      @$el.fadeIn()
      return this
    toggleSnippetContent: (e)->
      Logger.log "click"
      $content = $(e.currentTarget).next()
      $content.slideToggle("fast")
      this.$(".snippet-content").not($content).hide("fast")
      return
    updateSnippet:(e)->
      id = $(e.currentTarget).attr("data-id")
      Logger.log "update-snippet",id
      @trigger "click:update",{id}
      return
    deleteSnippet:(e)->
      id = $(e.currentTarget).attr("data-id")
      if id
        this.trigger "click:delete",{id}
      e.preventDefault()
      return false
    toggleFavorite:(e)->
      Logger.log e , id = e.currentTarget.getAttribute("data-id")
      @trigger 'click:favorite', id:id
      e.preventDefault()
      return false


