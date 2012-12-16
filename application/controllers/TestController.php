<?php

/**
 * @NOTE @ZEND TESTS divers et utilisation de php unit
 *
 */
class TestController extends Zend_Controller_Action {

  /**
   * @var Application_Form_TestForm
   */
  protected $test_form;

  /**
   * @var Application_Model_DbTable_Test 
   */
  protected $test_table;

  /**
   * @var Zend_Utils_CrudController
   */
  protected $crud_controller;

  public function init() {
    $this->test_table = new Application_Model_DbTable_Test();
    $this->test_form = new Application_Form_TestForm();
    $this->view->title = "Tests";
    $this->crud_controller = new Zend_Utils_CrudController();
    $this->crud_controller->init($this, "Tests");
  }

  public function indexAction() {
    $page = $this->getRequest()->getParam("page",1);
    $item_per_page = $this->getRequest()->getParam("item_per_page",5);
    $results = $this->crud_controller->showAll("tests", $this->test_table, "getAllItems");
    $paginator =  Zend_Paginator::factory($results->toArray());
    $paginator->setItemCountPerPage($item_per_page);
    $paginator->setCurrentPageNumber($page);
    $this->view->paginator = $paginator;
  }

  public function jsonAction() {
    // @NOTE @ZEND desactiver les vues , ce controlleur n'a pas besoin de vues.
    $this->_helper->viewRenderer->setNoRenderer(true);
  }

  public function createAction() {
    $this->crud_controller->create($this->test_form, $this->test_table, "createItem", "Item created successfully", "Error creating item");
  }
  
  public function updateAction(){
    $this->crud_controller->update($this->test_form, $this->test_table, "updateItem", "Test updated", "Error updating test");
  }
  
  public function deleteAction(){
    $this->crud_controller->delete($this->test_table, "deleteItem", "Test deleted successfully", "Error deleting item");
  }

}

