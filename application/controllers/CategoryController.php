<?php

class CategoryController extends Zend_Controller_Action
{

    protected $category_table = null;

    public function init()
    {
    $this->category_table = new Application_Model_DbTable_Category();
    #@NOTE @ZEND utiliser une variable de la vue pour afficher les messages de flashMessenger
    $this->view->title = "Categories";
    $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    /**
     * Lister les categories
     *
     */
    public function indexAction()
    {
    $categories = $this->category_table->fetchAll()->toArray();
    
    $this->view->categories = $categories;
    }

    public function createAction()
    {

    $form = new Application_Form_FormCategory();
    $form->removeElement("id");
    if ($this->getRequest()->isPost()):
      if ($form->isValid($_POST)):
        $formDatas = $form->getValues();
        $result = $this->category_table->insert(array("title" => $formDatas['title'], "description" => $formDatas["description"]));
        if ($result):
          $this->_helper->flashMessenger->addMessage("New category successfully created");
        else:
          $this->_helper->flashMessenger->addMessage("Error creating category");
        endif;
        $this->_helper->redirector("index");
      endif;
    endif;
    $this->view->form = $form;
    }

    public function deleteAction()
    {
    $id = $this->getParam("id");
    if ($id):
      $where = $this->category_table->getAdapter()->quoteInto("id = ?", $id);
      $result = $this->category_table->delete($where);
      if ($result):
        $this->_helper->flashMessenger->addMessage("Category successfully deleted");
      else:
        $this->_helper->flashMessenger->addMessage("Cannot delete that item");
      endif;
      $this->_helper->redirector("index");
    else:
      $this->_helper->flashMessenger->addMessage("No id provided");
    endif;
    $this->_helper->redirector("index");
    }

    public function updateAction()
    {
    $id = $this->getParam("id");
    $formDatas = $this->category_table->find($id)->current()->toArray();
    if ($id && $formDatas):
      $form = new Application_Form_FormCategory();
      if ($this->getRequest()->isPost()):
        if ($form->isValid($this->getAllParams())):
          $formValues = $form->getValues();
          $data = array();
          $data["title"] = $formValues["title"];
          $data["description"] = $formValues["description"];
          ///$data["updated"] = time();
          $where = $this->category_table->getAdapter()->quoteInto(" id = ? ", $id);
          $result = $this->category_table->update($data, $where);
          if ($result):
            $this->_helper->flashMessenger("Category $data[title] successfully updataed");
          else:
            $this->_helper->flashMessenger("Category update failed!");
          endif;
          $this->_helper->redirector("index");
        endif;
      else:
        $form->populate($formDatas);
      endif;
      $this->view->form = $form;
    else:
      $this->getHelper("flashMessenger")->addMessage("No id provided");
      $this->_helper->redirector("index");
    endif;
    }

    public function categoryListAction()
    {
        $categories = $this->category_table->fetchAll();
        $this->view->categories = $categories;
    }


}



