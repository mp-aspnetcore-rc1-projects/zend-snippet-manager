
define(function(require, exports, module) {
  var About, CategoryList, Head, Help, LoginForm, Model, ProgressDialog, Root, Snippet, SnippetForm, SnippetList;
  About = require("model/about");
  CategoryList = require('model/category-list');
  Head = require("model/head");
  Help = require("model/help");
  LoginForm = require("model/login-form");
  ProgressDialog = require("model/progress-dialog");
  Root = require("model/root");
  Snippet = require("model/snippet");
  SnippetForm = require("model/snippet-form");
  SnippetList = require("model/snippet-list");
  return Model = {
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
});
