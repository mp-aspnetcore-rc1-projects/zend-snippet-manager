
define(function(require) {
  var Logger, Root, options;
  require("lib/underscore.min");
  require("lib/backbone.min");
  Logger = require("util/logger");
  options = require("util/options");
  return Root = Backbone.View.extend({
    initialize: function(params) {
      this.category_list_view = params.category_list_view, this.snippet_form_view = params.snippet_form_view, this.snippet_list_view = params.snippet_list_view, this.app_head_view = params.app_head_view, this.progressDialog_view = params.progressDialog_view, this.login_form_view = params.login_form_view, this.about_view = params.about_view, this.help_view = params.help_view;
      Logger.log(this.category_list_view, this.snippet_list_view);
      _.bindAll(this);
      this.model.on("change", this.render);
      this.category_list_view.on("category:change", this.loadSnippets);
      this.app_head_view.on("click:mysnippets", this.loadSnippets);
      this.app_head_view.on("click:newsnippet", this.showSnippetForm);
      this.app_head_view.on("click:favoritesnippets", this.loadSnippets);
      this.app_head_view.on("select:autocomplete", this.renderAutoCompleteResult);
      this.app_head_view.on("submit:searchform", this.loadSnippets);
      this.app_head_view.on("click:login", this.showLoginForm);
      this.app_head_view.on("click:logout", this.logout);
      this.app_head_view.on("click:about", this.about);
      this.app_head_view.on("click:help", this.help);
      this.snippet_form_view.on("open:snippetform", this.loadComplete);
      this.snippet_list_view.on("click:update", this.showSnippetForm);
      this.snippet_list_view.on("click:delete", this.deleteSnippet);
      this.snippet_list_view.on("click:favorite", this.toggleFavorite);
      this.snippet_form_view.on("save:success", this.savesSnippet);
      this.login_form_view.on("open:loginform", this.loadComplete);
      this.login_form_view.on("login:success", this.loginSuccess);
      this.app_head_view.model.fetch();
      this.about_view.render();
      this.help_view.render();
      this.category_list_view.model.fetch({
        success: this.categoriesLoaded
      });
      this.progressDialog_view.model.set("message", "loading snippets...");
      this.loadStart();
      return this.loadSnippets();
    },
    loadStart: function(message) {
      if (message) this.progressDialog_view.model.set("message", message);
      return this.progressDialog_view.open();
    },
    loadComplete: function() {
      return this.progressDialog_view.close();
    },
    renderAutoCompleteResult: function(datas) {
      if (datas == null) datas = {};
      this.snippet_list_view.model.unset("subtitle");
      return this.snippet_list_view.model.set("snippets", datas.snippets);
    },
    loadSnippets: function(datas) {
      var params;
      if (datas == null) datas = {};
      if (_.isArray(datas)) {
        params = '';
        _.each(datas, function(data) {
          if (data._key && data._value) {
            return params += "/" + data._key + "/" + data._value;
          }
        });
        this.snippet_list_view.model.set("uri_param", params, {
          silent: true
        });
      } else {
        if (datas._key && datas._value) {
          this.snippet_list_view.model.set("uri_param", "/" + datas._key + "/" + datas._value, {
            silent: true
          });
        } else if (!datas._reload) {
          this.snippet_list_view.model.set("uri_param", null, {
            silent: true
          });
        }
      }
      this.loadStart("loading snippets...");
      return this.snippet_list_view.model.fetch({
        success: this.loadComplete
      });
    },
    showSnippetForm: function(datas) {
      if (datas == null) datas = {};
      Logger.log("show snippet form");
      this.loadStart("loading snippet form");
      this.snippet_form_view.model.set({
        "id": datas.id != null ? datas.id : ""
      }, {
        silent: true
      });
      return this.snippet_form_view.model.fetch();
    },
    deleteSnippet: function(datas) {
      var snippet;
      if (datas == null) datas = {};
      Logger.log("delete", datas);
      if (confirm("Delete this snippet ?") === false) return;
      if (datas.id) {
        Logger.log("delete snippet " + datas.id);
        this.loadStart("Deleting snippet");
        snippet = new App.Model.Snippet({
          id: datas.id
        });
        return snippet.destroy({
          success: this.snippetProcessed
        });
      }
    },
    snippetProcessed: function() {
      return this.snippet_list_view.model.fetch({
        success: this.loadComplete
      });
    },
    showLoginForm: function() {
      this.loadStart("Loading login Form...");
      return this.login_form_view.model.fetch();
    },
    loginSuccess: function(e) {
      this.app_head_view.model.fetch();
      return this.loadSnippets({
        _reload: true
      });
    },
    logout: function(datas) {
      this.loadStart("log out...");
      return this.login_form_view.model.logoutModel.save(null, {
        success: this.logoutSuccess
      });
    },
    logoutSuccess: function(model, response) {
      Logger.log(model, response, "logout complete");
      this.loadComplete();
      if (response.success === true) return window.location = "";
    },
    toggleFavorite: function(datas) {
      var _this = this;
      this.loadStart("Toggle favorite snippet...");
      return $.getJSON(options.getToggleFavoriteSnippetUri("/id/" + datas.id), function() {
        _this.loadComplete();
        return _this.loadSnippets({
          _reload: true
        });
      });
    },
    about: function() {
      return this.about_view.trigger("open");
    },
    help: function() {
      Logger.log("help@Root");
      return this.help_view.trigger("open");
    }
  });
});
