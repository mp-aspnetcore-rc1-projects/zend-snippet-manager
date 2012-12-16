
define(function(require, exports, module) {
  var options;
  require("lib/underscore.min");
  require("lib/backbone.min");
  options = {};
  options.APPLICATION_VERSION = 0.1;
  Backbone.emulateHTTP = true;
  Backbone.emulateJSON = true;
  options.SERVICE_URI = "";
  options.API_URI = "./api";
  options.GET_ALL_SNIPPETS_URI = "/getallsnippets";
  options.GET_SNIPPET_FORM_URI = "/getsnippetform";
  options.GET_CATEGORIES = "/getcategories";
  options.CREATE_SNIPPET_URI = "/createsnippet";
  options.UPDATE_SNIPPET_URI = "/updatesnippet";
  options.SAVE_SNIPPET_URI = "/savesnippet";
  options.USER_CREDENTIALS_URI = "/getusercredentials";
  options.USER_MENU_URI = "/getusermenu";
  options.LOGIN_FORM_URI = "/getloginform";
  options.LOGIN_URI = "/login";
  options.LOGOUT_URI = "/logout";
  options.JSON_FORMAT = "/format/json";
  options.SEARCH_URI = "/searchsnippet";
  options.TOGGLE_FAVORITE_URI = "/togglefavoritesnippet";
  options.viewModel = {};
  options.application_model = {};
  options.$target = void 0;
  options.$snippet_form = void 0;
  options.$login_form = void 0;
  options.$progressDialog = void 0;
  options.$mySnippetsLink = void 0;
  options.snippetListTemplateId = "#snippet-list-template";
  options.loginFormTemplateId = "#login-form-template";
  options.categoryListTemplateId = "#category-list-template";
  options.progressDialogTemplateId = '#progress-dialog-template';
  options.appHeadTemplate = "#app-head-template";
  options.snippetFormTemplate = "#snippet-form-template";
  options.appHeadId = "#app-head";
  options.loginFormId = "#login-form";
  options.snippetFormId = "#snippet-form";
  options.progressDialogId = "#progress-dialog";
  options.viewTemplateId = "#view-template";
  options.containerViewId = "#container";
  options.categoryViewId = "#category-list";
  options.snippetViewId = "#snippet-list";
  options.newSnippetLinkId = "#new-snippet-link";
  options.mySnippetsLinkId = "#my-snippets-link";
  options.snippetListClass = "snippet-list";
  options.updateSnippetClass = "update-snippet";
  options.deleteSnippetClass = "delete-snippet";
  options.favoriteSnippetClass = "favorite-snippet";
  options.dialgWidth = null;
  options.dialogHeight = null;
  options.dialogClass = "dialog";
  options.defaultDialogOptions = {
    modal: true,
    stack: true,
    dialogClass: options.dialogClass,
    title: "Snippet",
    show: {
      effect: 'drop',
      direction: "up"
    },
    hide: {
      effect: 'drop',
      direction: "down"
    },
    width: 600,
    position: "center",
    autoOpen: false
  };
  /*
    FONCTIONS
  */
  options.getSnippetsUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.GET_ALL_SNIPPETS_URI + params + options.JSON_FORMAT;
  };
  options.getLoginUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.LOGIN_URI + params + options.JSON_FORMAT;
  };
  options.getLogoutUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.LOGOUT_URI + params + options.JSON_FORMAT;
  };
  options.getSnippetFormUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.GET_SNIPPET_FORM_URI + params + options.JSON_FORMAT;
  };
  options.getSaveSnippetUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.SAVE_SNIPPET_URI + params + options.JSON_FORMAT;
  };
  options.getCreateSnippetUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.CREATE_SNIPPET_URI + params + options.JSON_FORMAT;
  };
  options.getUserCredentialsUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.USER_CREDENTIALS_URI + params + options.JSON_FORMAT;
  };
  options.getSnippetUpdateUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.UPDATE_SNIPPET_URI + params + options.JSON_FORMAT;
  };
  options.getUserMenuUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.USER_MENU_URI + params + options.JSON_FORMAT;
  };
  options.getSearchUri = function(params) {
    if (params == null) params = '';
    return options.SERVICE_URI + options.API_URI + options.SEARCH_URI + params + options.JSON_FORMAT;
  };
  options.getCategoriesUri = function(params) {
    if (params == null) params = '';
    return options.SERVICE_URI + options.API_URI + options.GET_CATEGORIES + params + options.JSON_FORMAT;
  };
  options.getLoginFormUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.LOGIN_FORM_URI + params + options.JSON_FORMAT;
  };
  options.getLogoutUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.LOGOUT_URI + params + options.JSON_FORMAT;
  };
  options.getToggleFavoriteSnippetUri = function(params) {
    if (params == null) params = "";
    return options.SERVICE_URI + options.API_URI + options.TOGGLE_FAVORITE_URI + params + options.JSON_FORMAT;
  };
  return exports.options = options;
});
