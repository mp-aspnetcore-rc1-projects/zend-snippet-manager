define (require,exports,module)->

  About          = require "model/about"
  CategoryList   = require 'model/category-list'
  Head           = require "model/head"
  Help           = require "model/help"
  LoginForm      = require "model/login-form"
  ProgressDialog = require "model/progress-dialog"
  Root           = require "model/root"
  Snippet        = require "model/snippet"
  SnippetForm    = require "model/snippet-form"
  SnippetList    = require "model/snippet-list"

  Model = {
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

