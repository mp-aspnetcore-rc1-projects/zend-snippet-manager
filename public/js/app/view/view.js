
define(function(require, exports) {
  var About, CategoryList, Head, Help, LoginForm, ProgressDialog, Root, Snippet, SnippetForm, SnippetList, View;
  About = require("view/about");
  CategoryList = require("view/category-list");
  Head = require("view/head");
  Help = require("view/help");
  LoginForm = require("view/login-form");
  ProgressDialog = require("view/progress-dialog");
  Root = require("view/root");
  Snippet = require("view/snippet");
  SnippetForm = require("view/snippet-form");
  SnippetList = require("view/snippet-list");
  View = {
    About: About,
    CategoryList: CategoryList,
    Head: Head,
    Help: Help,
    LoginForm: LoginForm,
    ProgressDialog: ProgressDialog,
    Root: Root,
    Snippet: Snippet,
    SnippetForm: SnippetForm,
    SnippetList: SnippetList
  };
  return exports.View = View;
});
