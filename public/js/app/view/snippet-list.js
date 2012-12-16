
define(function(require) {
  var Logger, SnippetList, options;
  require("lib/jquery");
  require("lib/jquery-ui");
  require("lib/underscore.min");
  require("lib/backbone.min");
  require("lib/prettify");
  options = require("util/options");
  Logger = require("util/logger");
  return SnippetList = Backbone.View.extend({
    tagName: "div",
    attributes: {
      "class": options.snippetListClass,
      sty: {
        e: "background:#EEE"
      }
    },
    className: options.snippetListClass,
    el: options.snippetViewId,
    template: _.template($(options.snippetListTemplateId).html()),
    events: {
      "click .snippet-head": "toggleSnippetContent",
      "click .favorite-snippet": "toggleFavorite",
      "click .update-snippet": "updateSnippet",
      "click .delete-snippet": "deleteSnippet"
    },
    initialize: function() {
      _.bindAll(this);
      return this.model.on("change", this.render);
    },
    render: function() {
      Logger.log("rendering snippet list");
      this.$el.hide();
      this.$el.html(this.template(this.model.toJSON()));
      prettyPrint();
      this.$(".snippet-content").hide();
      this.$el.fadeIn();
      return this;
    },
    toggleSnippetContent: function(e) {
      var $content;
      Logger.log("click");
      $content = $(e.currentTarget).next();
      $content.slideToggle("fast");
      this.$(".snippet-content").not($content).hide("fast");
    },
    updateSnippet: function(e) {
      var id;
      id = $(e.currentTarget).attr("data-id");
      Logger.log("update-snippet", id);
      this.trigger("click:update", {
        id: id
      });
    },
    deleteSnippet: function(e) {
      var id;
      id = $(e.currentTarget).attr("data-id");
      if (id) {
        this.trigger("click:delete", {
          id: id
        });
      }
      e.preventDefault();
      return false;
    },
    toggleFavorite: function(e) {
      var id;
      Logger.log(e, id = e.currentTarget.getAttribute("data-id"));
      this.trigger('click:favorite', {
        id: id
      });
      e.preventDefault();
      return false;
    }
  });
});
