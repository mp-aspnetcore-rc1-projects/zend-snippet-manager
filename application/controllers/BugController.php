<?php

class BugController extends Zend_Controller_Action {

  public function init() {
    $this->view->messages = $this->_helper->flashMessenger->getMessages();
  }

  public function indexAction() {
    //@NOTE @ZEND filtrer et ordonner une liste d'enrigstrement.
    $bugDbTable = new Application_Model_DbTable_Bug();
    // filter form
    $filterForm = new Application_Form_FormFilterBug();
    $this->view->filterForm = $filterForm;
    $sort = null;
    $filter = null;
    if ($this->getRequest()->isPost()):
      if ($filterForm->isValid($_POST)):
        $sortValue = $filterForm->getValue("sort");
        if ($sort != '0'):
          $sort = $sortValue;
        endif;
        $filterFieldValue = $filterForm->getValue("field");
        if ($filterFieldValue != '0'):
          $filter[$filterFieldValue] = $filterForm->getValue("filter");
        endif;
      endif;
    endif;
    // $bugs = $bugDbTable->listBugs($filter,$sort);
    //$this->view->bugs = $bugs;
    $adapter = $bugDbTable->fetchPaginatorAdapter($filter,$sort);
    $paginator = new Zend_Paginator($adapter);
    $paginator->setItemCountPerPage(10);
    $page = $this->_request->getParams("page",1);
    $paginator->setCurrentPageNumber($page);
    $this->view->paginator = $paginator;
    $this->view->title = "Bug list";
  }

  public function createAction() {
    $bugForm = new Application_Form_FormBug();
    if ($this->getRequest()->isPost()):
      if ($bugForm->isValid($_POST)):
        $datas = $bugForm->getValues();
        $bugTable = new Application_Model_DbTable_Bug();
        $result = $bugTable->createBug($datas);
        if ($result):
          $this->_helper->flashMessenger->addMessage("Bug report successfully created");
        else:
          $this->_helper->flashMessenger->addMessage("Error , cannot create bug report");
        endif;
        $this->_helper->redirector("index");
      endif;
    endif;
    $this->view->bugForm = $bugForm;
  }

  public function deleteAction() {
    $id = $this->getParam("id");
    if ($id):
      $db = new Application_Model_DbTable_Bug();
      $result = $db->deleteBug($id);
      if ($result):
        $this->_helper->flashMessenger->addMessage($this->view->translate("Bug report deleted successfully"));
      else:
        $this->_helper->flashMessenger->addMessage($this->view->translate("Error deleting bug report"));
      endif;
    else:
      $this->_helper->flashMessenger->addMessage($this->view->translate("Bug report not found"));
    endif;
    $this->_helper->redirector("index");
  }

  public function updateAction() {
    $id = $this->getParam("id");
    if ($id):
      $db = new Application_Model_DbTable_Bug();
      $bugForm = new Application_Form_FormBug();
      $bugForm->addElement("hidden", "id", array("required" => true, "value" => "id"));
      // si un formulaire a été envoyé
      if ($this->_request->isPost()):
        if ($bugForm->isValid($_POST)):
          $result = $db->updateBug($bugForm->getValues(), $id);
          if ($result):
            $this->_helper->flashMessenger->addMessage("Bug report udpated successfully");
          else:
            $this->_helper->flashMessenger->addMessage("Error cannot udpate bug report");
          endif;
        endif;
        $this->_helper->redirector("index");
      else:
        $datas = $db->find($id)->current();
        if ($datas):
          // report exists
          $bugForm->populate($datas->toArray());
        else:
          // report doesnt exist
          $this->_helper->flashMessenger->addMessage("Cannot find bug report");
          $this->_helper->redirector("index");
        endif;
      endif;
      $this->view->bugForm = $bugForm;
    else:
      // pas d'id
      $this->_helper->flashMessenger->addMessage("Cannot find bug report");
      $this->_helper->redirector("index");
    endif;
  }

}

