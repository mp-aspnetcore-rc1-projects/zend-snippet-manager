define (require)->

  require "lib/underscore.min"
  require "lib/backbone.min"
  options= require "util/options"
  Logger = require "util/logger"

  CategoryList = Backbone.View.extend
    el : options.categoryViewId
    events :
      'click .category-item' : 'onCategoryClick'
    initialize : ->
      @template = _.template $(options.categoryListTemplateId).html()
      _.bindAll this , 'render'
      @model.on("change",@render)
      return this
    render     : ->
      this.$el.html @template @model.toJSON()
      return this
    onCategoryClick : (e)->
      Logger.log 'click',e,e.target
      category_id = e.target.getAttribute("data-id")
      if this.model.get("category_id")!=category_id
        this.model.set("category_id",category_id)
        this.model.fetch(options.getSnippetsUri("/category_id/#{category_id}"))
        this.trigger("category:change",{_key:"category_id",_value:category_id})
      e.preventDefault()
      return false


