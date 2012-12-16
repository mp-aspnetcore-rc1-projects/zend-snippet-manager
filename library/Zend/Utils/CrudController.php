<?php

/**
 * une collection de méthodes utilitaires pour le CRUD
 */
class Zend_Utils_CrudController {

  /**
   * 
   * primary key of the main model used in the controller
   * @var string
   */
  public $id = "id";

  /**
   * @var Zend_Controller_Action 
   */
  protected $controller;

  /**
   *
   * generic init function
   * @param Zend_Controller_Action $controller
   */
  public function init(Zend_Controller_Action $controller, $title = " ") {
    $this->controller = $controller;
    $this->controller->view->title = $title;
    $this->controller->view->messages = $this->controller->getHelper("flashMessenger")->getMessages();
  }

  /**
   *
   * Show all crud method
   * @param Zend_Controller_Action $controller
   * @param string $viewModelName
   * @param class $modelClass
   * @param string $showAllFunction
   * @param string $successMessage
   * @param string $errorMessage
   * @param array $redirect
   * @param string $subtitle
   *
   * @return Zend_Db_Table_Rowset
   */
  public function showAll($viewModel, $model, $getAllFunction, $functionArguments = array(), $successMessage = "", $errorMessage = "", $redirect = array("index", "index"), $subtitle = "Show All") {
    $controller = $this->controller;
    $results = call_user_func_array(array($model, $getAllFunction), $functionArguments);
    $controller->view->subtitle = $subtitle;
    $controller->view->$viewModel = $results;
    return $results;
  }

  /**
   *
   * show one item crud method
   * @param Zend_Controller_Action $controller
   * @param string $viewModelName
   * @param string $modelClass
   * @param string $showFunction
   * @param string $successMessage
   * @param string $errorMessage
   * @param array $redirect
   * @param string $subtitle
   *
   * @return Zend_Db_Table_Row
   */
  public function show($viewModelName, $modelClass, $showFunction, $successMessage, $errorMessage, $redirect = array("index"), $subtitle = "Show") {
    $controller = $this->controller;
    $id = $controller->getParam($this->id);
    if ($id):
      $model = new $modelClass();
      $result = $model->$showFunction($id);
      if ($result):
        $controller->view->$viewModelName = $result;
        $controller->view->subtitle = $subtitle;
        return $result;
      else:
        $controller->getHelper("flashMessenger")->addMessage($errorMessage);
        call_user_func_array(array($controller->getHelper("redirector"), "direct"), $redirect);
      endif;
    else:
      $controller->getHelper("flashMessenger")->addMessage($errorMessage);
      call_user_func_array(array($controller->getHelper("redirector"), "direct"), $redirect);
    endif;
  }

  public function create(Zend_Form $form, $model, $createFunction, $successMessage, $errorMessage, $redirect = array("index"), $subtitle = "Create") {
    $controller = $this->controller;
    if ($controller->getRequest()->isPost()):
      if ($form->isValid($_POST)):
        $result = $model->$createFunction($form->getValues());
        if ($result):
          $controller->getHelper("flashMessenger")->addMessage("$successMessage");
        else:
          $controller->getHelper("flashMessenger")->addMessage("$errorMessage");
        endif;
        call_user_func_array(array($controller->getHelper("redirector"), direct), $redirect);
      endif;
    endif;
    $controller->view->subtitle = $subtitle;
    $formName = $form->getName();
    $controller->view->$formName = $form;
  }

  public function update($form, $model_table, $updateFunction, $successMessage, $errorMessage, $redirect = array("index"), $subtitle = "Update") {
    $controller = $this->controller;
    $controller->view->subtitle = "Update";
    //$form->getElement($this->id)->setRequired("true");
    $id = $controller->getParam($this->id);
    if ($controller->getRequest()->isPost()):
      if ($form->isValid($_POST)):
        $result = $model_table->$updateFunction($form->getValues(), $id);
        if ($result):
          $controller->getHelper("flashMessenger")->addMessage("$successMessage");
        else:
          $controller->getHelper("flashMessenger")->addMessage("$errorMessage");
        endif;
        call_user_func_array(array($controller->getHelper("redirector"), direct), $redirect);
      endif;
    else:
      $datas = $model_table->find($id)->current();
      if ($datas):
        $form->populate($datas->toArray());
      else:
        $controller->getHelper("flashMessenger")->addMessage("Item not found");
        $controller->getHelper("redirector")->direct("index");
      endif;
    endif;
    $controller->view->subtitle = $subtitle;
    $formName = $form->getName();
    $controller->view->$formName = $form;
  }

  public function delete($modelClass, $deleteFunction, $successMessage, $errorMessage, $redirector = array("index")) {
    $controller = $this->controller;
    $id = $controller->getParam($this->id);
    if ($id):
      $model = new $modelClass();
      $result = $model->$deleteFunction($id);
      if ($result):
        $controller->getHelper("flashMessenger")->addMessage("$successMessage");
      else:
        $controller->getHelper("flashMessenger")->addMessage("$errorMessage");
      endif;
    else:
      $controller->getHelper("flashMessenger")->addMessage("Nothing to delete");
    endif;
    call_user_func_array(array($controller->getHelper("redirector"), "direct"), $redirector);
  }

}

?>