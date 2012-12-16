<?php

class SnippetController extends Zend_Controller_Action {

  /**
   * @var Application_Model_DbTable_Category
   */
  protected $categories;

  /**
   * @var Application_Model_DbTable_Snippet
   */
  protected $snippets;

  public function init() {
    /* Initialize action controller here */
    #@NOTE @ZEND utiliser un layout alternatif
    // $this->layout = $this->_helper->layout();
    // $this->layout->setLayout("snippet-manager");
    // @NOTE @ZEND context switch
    // permet de servire automatiquement un format
    $this->account = Zend_Auth::getInstance()->getIdentity();
    $this->snippets = new Application_Model_DbTable_Snippet();
    $category_table = new Application_Model_DbTable_Category();
    $this->flashMessenger = $this->_helper->flashMessenger;
    $_cs = $this->_helper->getHelper("contextSwitch");
    //@NOTE @ZEND permettre au controlleur d'afficher du json
    $_cs->addActionContext('index', 'json')->initContext();
    $_cs->addActionContext('show', 'json')->initContext();
    parent::init();
    $this->view->title = "Snippets";
    $this->view->categories = $category_table->fetchAll()->toArray();
    $this->view->messages = $this->_helper->flashMessenger->getMessages();
  }

  public function indexAction() {
    $page = $this->getRequest()->getParam("page", 1);
    $items_per_page = $this->getRequest()->getParam("items_per_page", 10);
    $select = $this->snippets->select();
    $this->_getIndexSelect($select);
    if ($this->account):
      if ($this->account->role != "administrator"):
        $snippets = $this->_selectAllSnippetsForRegisteredUser($select);
      endif;
    else:
      $this->_selectAllSnippetsForUnregisteredUser($select);
    endif;
    $select->order("created DESC");
    // $this->snippets->fetchAll($select);
    $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbTableSelect($select));
    $paginator->setItemCountPerPage($items_per_page);
    $paginator->setCurrentPageNumber($page);
    $this->view->snippets = $paginator;
  }

  public function showAction() {
    // @ZEND @NOTE désactiver le layout
    //$this->_helper->layout()->disableLayout();
    $result = null;
    $id = $this->_request->getParam("id");
    $title = $this->_request->getParam("title");
    if ($id != null):
      $result = $this->showById($id);
    elseif ($title != null):
      $result = $this->showByTitle(urldecode($title));
    endif;
    /** @NOTE @ZEND current :  retourne un seul enregistrement * */
    if ($result && ( $result->private == 0 || ($result->private == 1 && $this->account->id && $result->belongsToUser($this->account->id)) )):
      $this->view->subtitle = $result->title;
      $this->view->snippet = $result;
      if ($this->account != null):
        $this->view->account = $this->account;
      endif;
    else:
      $this->_helper->flashMessenger->addMessage("Snippet not found");
      $this->_helper->redirector("index");
    endif;
  }

  protected function showById($id) {
    $snippets = new Application_Model_DbTable_Snippet();
    return $snippets->find($id)->current();
  }

  protected function showByTitle($title) {
    $snippets = new Application_Model_DbTable_Snippet();
    return $snippets->findByTitle($title);
  }

  public function createAction() {
    // action body
    $form = new Application_Form_FormSnippet();

    if ($this->getRequest()->isPost()):
      if ($form->isValid($_POST)):
        $snippets = new Application_Model_DbTable_Snippet();
        $datas = $form->getValues();
        $datas["user_id"] = $this->account->id;
        $result = $snippets->create($datas);
        if ($result):
          $this->flashMessenger->addMessage("A new snippet was successfully created");
          $this->_helper->redirector("show", "snippet", null, array("id" => $result));
        endif;
      endif;
    endif;
    $this->view->form = $form;
    $this->view->subtitle = "Add new snippet";
  }

  public function updateAction() {

    $id = $this->getRequest()->getParam("id");

    if ($id == null):
      $this->_helper->flashMessenger->addMessage("No snippet to update");
      $this->_helper->redirector("index");
    endif;

    if (!($this->account->role == "administrator" || $this->snippets->belongsToUser($id, $this->account->id))):
      $this->_helper->flashMessenger->addMessage("Unable to update this snippet $id {$this->account->id} ");
      $this->_helper->redirector("index");
    endif;
    $form = new Application_Form_FormSnippet();
    if ($this->getRequest()->isPost()):
      if ($form->isValid($_POST)):
        $datas = $form->getValues();
        $datas["id"] = $id;
        $datas["user_id"] = $this->account->id;
        $result = $this->snippets->updateItem($datas, $id);
        if ($result != null):
          $this->flashMessenger->addMessage("The snippet was updated");
          $this->_helper->redirector("show", "snippet", null, array("id" => $id));
        else:
          $this->flashMessenger->addMessage("snippet update failed");
          $this->_helper->redirector("index");
        endif;
      endif;
    elseif ($id):
      $snippet = $this->snippets->find($id)->current();
      if ($snippet != null):

        $form->addElements(array(
          "id" => array(
            "type" => "hidden",
            "name" => "id",
            "options" => array(
              "required" => true
            )
          )
        ));
        $form->populate($snippet->toArray());
      endif;
    else:
    endif;
    $this->view->form = $form;
  }

  public function deleteAction() {
    $id = $this->getRequest()->getParam("id");
    if (!($this->account->role == "administrator" || $this->snippets->belongsToUser($this->account->id))):
      $this->_helper->flashMessenger->addMessage("Unable to delete this snippet");
      $this->_helper->redirector("index");
    endif;
    if ($id != null):
      $delete = $this->snippets->deleteSnippet($id);
      if ($delete):
        $this->_helper->flashMessenger("Snippet deleted");
      else:
        $this->_helper->flashMessenger("No snippet deleted");
      endif;
    endif;
    $this->_helper->redirector("index");
  }

  public function searchAction(){
    $term = $this->getRequest()->getParam("search-input");
  }

  protected function _selectAllSnippetsForUnregisteredUser(Zend_Db_Select $select) {
    $select->where(" private = ? ", 0);
    return $select;
  }

  protected function _selectAllSnippetsForRegisteredUser(Zend_Db_Select $select) {
    $select->where("private = ?", 0)->orWhere(" private = 1 AND user_id = ? ", $this->account->id);
    return $select;
  }

  /**
   * @return Zend_Db_Select
   */
  protected function _getIndexSelect(Zend_Db_Select $select) {
    $category_id = $this->_request->getParam("category_id");
    $user_id = $this->_request->getParam("user_id");
    $account = $this->_request->getParam("account");


    if ($user_id):
      $select->where(" user_id = ? ", $user_id);
    endif;
    if ($category_id):
      $select->where(" category_id = ? ", $category_id);
      $this->view->subtitle = "{$this->getSubtitleFromCategoryId($category_id)} snippets";
    endif;
    if ($account && $this->account->id):
      $select->where(" user_id = ?", $this->account->id);
    endif;
    return $select;
  }

  /**
   * verifier si un snippet $id appartient à l'user $user_id
   * @param integer $id
   * @param integer $user_id
   * @return boolean
   */
  protected function _belongsToUser($id, $user_id) {
    $snippet = $this->snippets->belongsToUser($id, $user_id);
    if ($snippet != null):
      return true;
    else:
      return false;
    endif;
  }

  /**
   *
   * trouve la catégorie associée à l'id.
   * @param integer $id
   */
  protected function getSubtitleFromCategoryId($id) {
    if ($id):
      foreach ($this->view->categories as $category):
        if ($category['id'] == $id):
          return $category["title"];
        endif;
      endforeach;
    endif;
  }

}

