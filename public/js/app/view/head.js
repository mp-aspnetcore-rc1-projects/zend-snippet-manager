
define(function(require) {
  var Head, Logger, options;
  require("lib/jquery");
  require("lib/jquery-ui");
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = require("util/options");
  Logger = require("util/logger");
  return Head = Backbone.View.extend({
    events: {
      "click #my-snippets-link": "mysnippetsclick",
      "click #new-snippet-link": "newsnippetclick",
      "click #favorite-snippets-link": "favoritesnippetsclick",
      "submit #search-form": "search",
      "click #login-link": "login",
      "click #logout-link": "logout",
      "click #about-link": "about",
      "click #help-link": "help"
    },
    el: $(options.appHeadId),
    initialize: function() {
      _.bindAll(this);
      this.template = _.template($(options.appHeadTemplate).html());
      return this.model.on("change", this.render);
    },
    render: function() {
      var _this = this;
      this.$el.hide().html(this.template(this.model.toJSON())).fadeIn();
      return this.$el.find("#search").autocomplete({
        source: function(request, response) {
          return $.getJSON(options.getSnippetsUri(), request, function(datas) {
            var result;
            result = _.map(datas.snippets, function(snippet) {
              var category;
              category = _.find(datas.categories, function(category) {
                return category.id === snippet.category_id;
              });
              return {
                label: "" + category.title + " : " + snippet.title,
                value: snippet.title,
                id: snippet.id,
                snippet: snippet
              };
            });
            return response(result);
          });
        },
        select: function(event, ui) {
          return _this.trigger("select:autocomplete", {
            snippets: [ui.item.snippet]
          });
        },
        minLength: 2
      });
    },
    mysnippetsclick: function(e) {
      return this.trigger("click:mysnippets", {
        _key: "user_id",
        _value: this.model.get("user_id")
      });
    },
    newsnippetclick: function(e) {
      return this.trigger("click:newsnippet");
    },
    favoritesnippetsclick: function(e) {
      return this.trigger("click:favoritesnippets", {
        _key: "show_favorites",
        _value: true
      });
    },
    search: function(event) {
      var keyword;
      keyword = this.$el.find("#search").val().trim();
      Logger.log("search", keyword);
      if (keyword) {
        this.trigger("submit:searchform", [
          {
            _key: "term",
            _value: keyword
          }, {
            _key: "mode",
            _value: "global"
          }
        ]);
      }
      event.preventDefault;
      return false;
    },
    login: function(event) {
      Logger.log("login", event);
      this.trigger("click:login");
      event.preventDefault();
      return false;
    },
    logout: function(event) {
      Logger.log("logout", event);
      this.trigger("click:logout", "log out");
      event.preventDefault;
      return false;
    },
    doLogout: function() {
      return this.logoutModel.save({
        success: logOutSuccess
      });
    },
    about: function() {
      return this.trigger("click:about");
    },
    help: function() {
      Logger.log("help@Head");
      this.trigger("click:help");
      return false;
    }
  });
});
