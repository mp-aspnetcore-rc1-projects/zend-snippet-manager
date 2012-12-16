
define(function(require, exports, module) {
  var App, Main;
  require("lib/jquery");
  require("util/plugin/jquery/serializetoarray");
  require("lib/jquery-ui");
  require("lib/underscore.min");
  require("lib/backbone.min");
  App = require("app");
  App.Logger.state = false;
  App.Logger.log(App);
  Main = function() {
    this.progressDialog = new App.Model.ProgressDialog();
    this.app_head = new App.Model.Head();
    this.categories = new App.Model.CategoryList();
    this.snippets = new App.Model.SnippetList();
    this.login_form = new App.Model.LoginForm();
    this.snippet_form = new App.Model.SnippetForm();
    this.about = new App.Model.About();
    this.help = new App.Model.Help();
    this.progressDialog_view = new App.View.ProgressDialog({
      model: this.progressDialog
    });
    this.app_head_view = new App.View.Head({
      model: this.app_head
    });
    this.category_list_view = new App.View.CategoryList({
      model: this.categories
    });
    this.snippet_list_view = new App.View.SnippetList({
      model: this.snippets
    });
    this.snippet_form_view = new App.View.SnippetForm({
      model: this.snippet_form
    });
    this.login_form_view = new App.View.LoginForm({
      model: this.login_form
    });
    this.about_view = new App.View.About({
      model: this.about
    });
    this.help_view = new App.View.Help({
      model: this.help
    });
    this.root = new App.Model.Root();
    this.root_view = new App.View.Root({
      model: this.root,
      category_list_view: this.category_list_view,
      snippet_list_view: this.snippet_list_view,
      progressDialog_view: this.progressDialog_view,
      app_head_view: this.app_head_view,
      snippet_form_view: this.snippet_form_view,
      login_form_view: this.login_form_view,
      about_view: this.about_view,
      help_view: this.help_view
    });
    return this;
  };
  window.App = App;
  window.Main = Main;
  $(function() {
    return window.main = new Main();
  });
});
