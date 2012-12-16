<?php

class MenuController extends Zend_Controller_Action {

  protected $account = null;

  public function init() {
    Zend_Utils_CrudController::init($this, "Menu management");
    $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()):
      $this->account = $auth->getIdentity();
    else:
    endif;
  }

  public function indexAction() {
    $menus = Zend_Utils_CrudController::showAll($this, "menus", "Application_Model_DbTable_Menu", "getAllItems");
    $this->view->subtitle = "Menu list";
  }

  public function createAction() {
    Zend_Utils_CrudController::create($this, "Application_Form_FormMenu", "Application_Model_DbTable_Menu", "createItem", "Menu created", "Error creating menu");
  }

  public function updateAction() {
    Zend_Utils_CrudController::update($this, "Application_Form_FormMenu", "Application_Model_DbTable_Menu", "updateItem", "Menu updated", "Erroe updating menu");
  }

  public function deleteAction() {
    Zend_Utils_CrudController::delete($this, "Application_Model_DbTable_Menu", "deleteItem", "the menu was successfully deleted", "Error deleting menu");
  }

  public function showAction() {
    Zend_Utils_CrudController::show($this, "menu", "Application_Model_DbTable_Menu", "getItem", "", "Menu doesnt exists");
  }

  public function renderAction() {

      if ($this->account == null)
        return;
      $this->view->actionTitle = "User menu";
      $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', "nav");
      $nav = new Zend_Navigation($config);
      $this->account == null AND $role = "guest";
      $this->account != null AND $role = $this->account->role;
      $this->view->navigation($nav)->setAcl(Zend_Registry::get("acl"))->setRole($role);

  }

}

