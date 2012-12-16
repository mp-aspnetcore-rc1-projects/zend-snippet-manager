<?php

class Rest_IndexController extends Zend_Rest_Controller {

  /**
   * @var Zend_Db_Table_Abstract
   *
   */
  protected $category_table = null;

  /**
   * @var Zend_Db_Table_Rowset
   *
   */
  protected $categories = null;

  /**
   * @var Zend_Form 
   *
   */
  protected $snippetForm = null;

  /**
   * @var Zend_Db_Table
   *
   */
  protected $snippet_table = null;

  /**
   *
   * @var Zend_Db_Table
   */
  protected $favorite_table = null;

  /**
   *
   * @var Application_Model_DbTable_Account
   */
  protected $account_table = null;

  public function init() {
    // $this->_init();
    $this->_helper->viewRenderer->setNoRender(true);
    $this->getHelper("layout")->disableLayout();

    $bootsrap = $this->getInvokeArg("bootstrap");
    $options = $bootsrap->getOption('resources');
    $contextSwitch = $this->getHelper("contextSwitch");
    $contextSwitch->addActionContext("index", array("json"))
        ->addActionContext("get", array("json"))
        ->addActionContext("delete", array("json"))
        ->addActionContext("put", array("json"))
        ->addActionContext("post", array("json"))
        ->addActionContext("head", array("json"))->initContext("json");
  }

  public function deleteAction() {
    $this->_createResponse("delete");
  }

  public function getAction() {
    $this->_createResponse("get");
  }

  public function indexAction() {
    $this->_createResponse("index");
  }

  public function postAction() {
    $this->_createResponse("post");
  }

  public function putAction() {

    $this->_createResponse("put");
  }

  public function headAction() {
    $this->_createResponse("head");
  }

  /* public function indexAction() {

    } */
  /*
    public function getallsnippetsAction() {
    $category_id = $this->getRequest()->getParam("category_id");
    $user_id = $this->getRequest()->getParam("user_id");
    $show_favorites = $this->getRequest()->getParam("show_favorites");
    $term = $this->getRequest()->getParam("term");
    $account_id = null;
    $account_role = null;
    if ($this->account) {
    $account_id = $this->account->id;
    $account_role = $this->account->role;
    $this->view->user_id = $account_id;
    #obtenir les favoris
    $this->view->favorites = $this->favorite_table->getUserFavoritesList($this->account->id);
    if ($show_favorites):
    $results = $this->account_table->findUserFavorites($this->account->id);
    if ($results):
    $this->view->snippets = $results->toArray();
    $this->view->subtitle = "Favorite snippets";
    $this->view->success = true;
    else:
    $this->view->success = false;
    $this->view->error = "cannot get favorites";
    endif;
    return;
    endif;
    }
    $results = $this->snippet_table->getAll($category_id, $user_id, $account_id, $account_role, $term);
    if ($results):
    $this->view->success = true;
    $this->view->snippets = $results->toArray();
    $this->view->categories = $this->categories->toArray();
    $this->view->category_id = $category_id;
    if ($user_id):
    $this->view->subtitle = "My snippets";
    elseif ($category_id):
    $this->view->subtitle = "Snippets : " . $this->category_table->find($category_id)->current()->title;
    endif;
    else:
    $this->view->success = false;
    endif;
    }

    public function getsnippetformAction() {
    $id = $this->getRequest()->getParam("id");
    if ($id):
    // update
    $snippet = $this->snippet_table->find($id)->current();
    if ($snippet && $this->account && $snippet->user_id == $this->account->id):
    $this->snippetForm->populate($snippet->toArray());
    $this->view->snippet_form = $this->snippetForm->render();
    $this->view->id = $snippet->id;
    $this->view->success = true;
    $this->view->subtitle = "Update snippet";
    return;
    else:
    $this->view->success = false;
    $this->view->error = "Cannot find snippet";
    return;
    endif;
    else:
    // nouveau
    $this->view->success = true;
    $this->view->subtitle = "New snippet";
    $this->view->snippet_form = $this->snippetForm->render();
    endif;
    }

    public function getloginformAction(){
    Zend_Auth::getInstance()->clearIdentity();
    $model = $this->getRequest()->getParam("model");
    $datas = Zend_Json::decode($model);
    $loginForm = new Application_Form_FormLogin();
    $loginForm->removeElement("submit");
    if($this->getRequest()->isPost() ):
    if($loginForm->isValid($datas)):
    $auth = $this->_helper->authenticate($datas);
    if($auth==true):
    #success
    $this->view->success = true;
    else:
    $this->view->success = false ;
    $this->view->error = "Auth failed";
    endif;
    else:
    $this->view->success = false;
    $this->view->error = "Form is invalid";
    endif;
    else:
    $this->view->success = false ;
    endif;
    $this->view->login_form = $loginForm->render();
    $this->view->subtitle = "Login";
    }


    public function logoutAction(){
    if($this->account):
    Zend_Auth::getInstance()->clearIdentity();
    $this->view->success = true;
    else:
    $this->view->success = false;
    endif;
    }

    public function savesnippetAction() {
    $this->view->controller = "savesnippet";
    $id = $this->getRequest()->getParam("id");
    $method = $this->getRequest()->getParam("_method");
    if ($id):
    if ($method == "PUT"):
    $this->updatesnippet();
    elseif ($method == "DELETE"):
    $this->deletesnippet();
    else:
    $this->view->success = false;
    $this->view->error = "method unvalid";
    return;
    endif;
    elseif ($method == "PUT"):
    $this->createsnippet();
    endif;
    }

    public function getcategoriesAction(){
    $this->view->category_id = $this->getRequest()->getParam("category_id");
    $this->view->categories = $this->categories->toArray();
    $this->view->success = true ;
    }

    public function deletesnippet() {
    $id = $this->getRequest()->getParam("id");
    if ($id && $this->account && $this->snippet_table->belongsToUser($id, $this->account->id)):
    $result = $this->snippet_table->deleteItem($id);
    if ($result):
    $this->view->success = true;
    return;
    endif;
    endif;
    $this->view->success = false;
    $this->view->error = "Cant delete snippet";
    }

    public function favoritesnippetAction() {
    $user_id = $this->getRequest()->getParam("user_id");
    if ($user_id):
    $favorites = $this->favorite_table->getFavoritesByUserId($user_id);
    if ($result):
    foreach ($favorites as $favorite):
    $rowset[] = $favorite->findParentRow("Application_Model_DbTable_Snippet")->toArray();
    endforeach;
    $this->view->subtitle = "Favorites";
    $this->view->snippets = $rowset;
    $this->view->categories = $this->categories->toArray();
    endif;
    endif;
    }

    // CREER un favori si le snippet n'est pas favori , DETRUIRE le favori si il existe
    public function togglefavoritesnippetAction(){
    $snippet_id = $this->getRequest()->getParam("id");
    if($this->account):
    $query = $this->favorite_table->select();
    $query->where(" snippet_id = ? ",$snippet_id);
    $query->where(" user_id = ?",$this->account->id);
    $result = $this->favorite_table->fetchRow($query);
    if ( $result ):
    $delete = $result->delete();
    $this->view->success  = true;
    else :
    $row = $this->favorite_table->createRow();
    $row->snippet_id = $snippet_id;
    $row->user_id = $this->account->id;
    $save = $row->save();
    if($save):
    $this->view->success = true ;
    else:
    $this->view->success = false;
    $this->view->message = "cant save new favorite";
    endif;
    endif;
    else:
    $this->view->success = false;
    endif;
    }
    protected function createsnippet() {
    if ($this->getRequest()->isPost() && $this->account):
    $model = Zend_Json::decode($this->getRequest()->getParam("model"));
    if ($this->snippetForm->isValid($model)):
    $datas = $model;
    $datas["user_id"] = $this->account->id;
    $result = $this->snippet_table->create($datas);
    if ($result):
    $this->view->success = true;
    $this->view->close = true;
    else:
    $this->view->success = false;
    $this->view->close = true;
    $this->view->error = "Cant save new snippet.";
    endif;
    else :
    $this->view->success = false;
    $this->view->close = false;
    $this->view->error = "form create not valid.";
    $this->view->snippet_form = $this->snippetForm->render();
    endif;
    else:
    $this->view->success = false;
    $this->view->error = "not a valid request.";
    endif;
    }

    protected function updatesnippet() {
    $id = $this->getRequest()->getParam("id");

    if ($id) {
    if ($this->getRequest()->isPost()) {
    $model = Zend_Json::decode($this->getRequest()->getParam("model"));
    if ($this->snippetForm->isValid($model)):
    $model["user_id"] = $this->account->id;
    $result = $this->snippet_table->updateItem($model, $id);
    if ($result):
    $this->view->success = true;
    else:
    $this->view->success = false;
    $this->view->error = "Cannot update snippet";
    endif;
    else:
    // form is not valid , render the form with erros
    $this->view->success = false;
    $this->view->error = "form update is not valid";
    $this->view->snippet_form = $this->snippetForm->render();
    endif;
    }
    }else {
    $this->view->success = false;
    $this->view->error = "No snippet id provided";
    }
    }

    public function getusercredentialsAction() {
    if ($this->account):
    $this->view->success = true;
    $this->view->user_id = $this->account->id;
    $this->view->username = $this->account->username;
    $this->view->role = $this->account->role;
    else:
    $this->view->success = false;
    $this->view->user_id = null;
    $this->view->username=null;
    $this->view->role=null;
    endif;
    }

    public function getusermenuAction() {
    $this->view->success = true;

    if ($this->account) {
    $this->view->user_id = $this->account->id;
    $this->view->username = $this->account->username;
    $this->view->role = $this->account->role;
    }
    }

    public function searchsnippetAction() {
    $term = $this->getRequest()->getParam("term");
    if ($term):
    $query = $this->snippet_table->select();
    $query->where(" title LIKE ? ", "%$term%");
    $results = $this->snippet_table->fetchAll($query);
    $this->view->snippets = $results->toArray();
    endif;
    } */

  public function _init() {

    $this->_helper->layout()->disableLayout();
    $this->getHelper("viewRenderer")->setNoRender();

    // get cateogries
    $this->category_table = new Application_Model_DbTable_Category();
    $this->categories = $this->category_table->getAllItems();
    $this->snippet_table = new Application_Model_DbTable_Snippet();
    $this->favorite_table = new Application_Model_DbTable_Favorite();
    $this->account_table = new Application_Model_DbTable_Account();
    $this->snippetForm = new Application_Form_FormSnippet();
    $this->snippetForm->removeElement("submit");
    $this->snippetForm->removeElement("reset");
    $this->snippetForm->getElement("content")->setOptions(array("rows" => 15, "cols" => 100));

    $this->account = Zend_Auth::getInstance()->getIdentity();
    // Initialize action controller here 
    //Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
    $_cs = $this->_helper->getHelper("contextSwitch");
    //@NOTE @ZEND permettre au controlleur d'afficher du json
    $_cs->addActionContext('index', 'json')->initContext();
    $_cs->addActionContext('getallsnippets', 'json')->initContext();
    $_cs->addActionContext('getsnippetform', 'json')->initContext();
    $_cs->addActionContext('createsnippet', 'json')->initContext();
    $_cs->addActionContext('getusercredentials', 'json')->initContext();
    $_cs->addActionContext('updatesnippet', 'json')->initContext();
    $_cs->addActionContext('getusermenu', 'json')->initContext();
    $_cs->addActionContext('savesnippet', 'json')->initContext();
    $_cs->addActionContext('deletesnippet', 'json')->initContext();
    $_cs->addActionContext('searchsnippet', 'json')->initContext();
    $_cs->addActionContext('getcategories', 'json')->initContext();
    $_cs->addActionContext('getloginform', 'json')->initContext();
    $_cs->addActionContext('login', 'json')->initContext();
    $_cs->addActionContext('logout', 'json')->initContext();
    $_cs->addActionContext('togglefavoritesnippet', 'json')->initContext();
    //$this->getResponse()->setHeader("Access-Control-Allow-Origin", "*");
  }

  protected function _createResponse($method) {
    $params = $this->getRequest()->getParams();
    /*$this->getResponse()
        ->appendBody("$method :  $params");*/
    $this->view->datas = array("method"=>$method,"params"=>$params);
    $this->view->success=true;
  }

}

