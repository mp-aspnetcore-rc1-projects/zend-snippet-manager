define (require,exports)->

  About          = require "view/about"
  CategoryList   = require "view/category-list"
  Head           = require "view/head"
  Help           = require "view/help"
  LoginForm      = require "view/login-form"
  ProgressDialog = require "view/progress-dialog"
  Root           = require "view/root"
  Snippet        = require "view/snippet"
  SnippetForm    = require "view/snippet-form"
  SnippetList    = require "view/snippet-list"

  View = {
    About
    CategoryList
    Head
    Help
    LoginForm
    ProgressDialog
    Root
    Snippet
    SnippetForm
    SnippetList
  }

  exports.View = View
