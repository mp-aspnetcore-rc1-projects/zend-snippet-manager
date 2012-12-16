define (require,exports,module)->

  require "lib/jquery"
  require "util/plugin/jquery/serializetoarray"
  require "lib/jquery-ui"
  require "lib/underscore.min"
  require "lib/backbone.min"

  App = require "app"
  
  App.Logger.state = off

  App.Logger.log App

  Main= ->
  
    @progressDialog = new App.Model.ProgressDialog()
    @app_head = new App.Model.Head()
    @categories = new App.Model.CategoryList()
    @snippets = new App.Model.SnippetList()
    @login_form = new App.Model.LoginForm()
    @snippet_form = new App.Model.SnippetForm()
    @about = new App.Model.About()
    @help  = new App.Model.Help()

    @progressDialog_view = new App.View.ProgressDialog {model:@progressDialog}

    @app_head_view = new App.View.Head {model:@app_head}
    
    @category_list_view = new App.View.CategoryList
      model:@categories
    
    @snippet_list_view = new App.View.SnippetList
      model:@snippets

    @snippet_form_view = new App.View.SnippetForm {model:@snippet_form}
    
    @login_form_view = new App.View.LoginForm {model:@login_form}

    @about_view = new App.View.About model:@about
    @help_view = new App.View.Help model:@help

    @root = new App.Model.Root()

    @root_view = new App.View.Root
      model:@root
      category_list_view:@category_list_view
      snippet_list_view:@snippet_list_view
      progressDialog_view:@progressDialog_view
      app_head_view : @app_head_view
      snippet_form_view : @snippet_form_view
      login_form_view: @login_form_view
      about_view : @about_view
      help_view  : @help_view
    return this

  window.App  = App
  window.Main = Main

  $ ->
    window.main = new Main()

  return
