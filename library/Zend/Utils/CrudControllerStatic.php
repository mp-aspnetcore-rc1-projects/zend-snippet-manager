<?php
/**
 * une collection de méthodes utilitaires pour le CRUD
 */
class Zend_Utils_CrudControllerStatic{
	
	/**
	 * 
	 * primary key of the main model used in the controller
	 * @var string
	 */
	public static $id = "id";
	
	/**
	 * 
	 * generic init function
	 * @param Zend_Controller_Action $controller
	 */
	public static function init(Zend_Controller_Action $controller,$title=" "){
		$controller->view->title = $title;
		$controller->view->messages = $controller->getHelper("flashMessenger")->getMessages();
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
	public static function showAll(Zend_Controller_Action $controller,$viewModelName,$modelClass,$showAllFunction, $functionArguments=array(),$successMessage="",$errorMessage="",$redirect=array("index","index"),$subtitle="Show All"){
		$model = new $modelClass();
		$results = call_user_func_array(array($model,$showAllFunction),$functionArguments);
		$controller->view->subtitle = $subtitle;
		$controller->view->$viewModelName = $results;
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
	public static function show(Zend_Controller_Action $controller,$viewModelName,$modelClass,$showFunction,$successMessage,$errorMessage,$redirect=array("index"),$subtitle="Show"){
		$id = $controller->getParam("id");
		if($id):
			$model = new $modelClass();
			$result = $model->$showFunction($id);
			if($result):
				$controller->view->$viewModelName = $result;
				$controller->view->subtitle = $subtitle;
				return $result;
			else:
				$controller->getHelper("flashMessenger")->addMessage($errorMessage);
				call_user_func_array(array($controller->getHelper("redirector"),"direct" ), $redirect);
			endif;
		else:
			$controller->getHelper("flashMessenger")->addMessage($errorMessage);
			call_user_func_array(array($controller->getHelper("redirector"),"direct" ), $redirect);
		endif;
		
		
	}
	
	public static function create($controller,$formClass,$modelClass,$createFunction,$successMessage,$errorMessage,$redirect=array("index"),$subtitle="Create") {
		$form = new $formClass();
		if($controller->getRequest()->isPost()):
			if($form->isValid($_POST)):
				$model = new $modelClass();
				$result = $model->$createFunction($form->getValues());
				if($result):
					$controller->getHelper("flashMessenger")->addMessage("$successMessage");
				else:
					$controller->getHelper("flashMessenger")->addMessage("$errorMessage");
				endif;
				call_user_func_array(array($controller->getHelper("redirector"),direct),$redirect);
			endif;
		endif;
		$controller->view->subtitle = $subtitle;
		$formName=$form->getName() ;
		$controller->view->$formName= $form;
		//var_dump($controller->view);
	}
	
	public static function update(Zend_Controller_Action $controller,$formClass,$modelClass,$updateFunction,$successMessage,$errorMessage,$redirect=array("index"),$subtitle="Update"){
		$controller->view->subtitle = "Update";
		$form = new $formClass();
		$form->getElement("id")->setRequired("true");
		$model_table = new $modelClass();
		$id = $controller->getParam("id");
		if($controller->getRequest()->isPost()):
			if($form->isValid($_POST)):
				$result = $model_table->$updateFunction($form->getValues(),$id);
				if($result):
					$controller->getHelper("flashMessenger")->addMessage("$successMessage");
				else:
					$controller->getHelper("flashMessenger")->addMessage("$errorMessage");
				endif;
				call_user_func_array(array($controller->getHelper("redirector"),direct),$redirect);
			endif;
		else:
			$datas = $model_table->find($id)->current();
			if($datas):
				$form->populate($datas->toArray());
			else:
				$controller->getHelper("flashMessenger")->addMessage("Item not found");
				$controller->_helper->redirector("index");
			endif;
		endif;
		$controller->view->subtitle = $subtitle;
		$formName  = $form->getName() ;
		$controller->view->$formName= $form;
	}
	
	public static function delete(Zend_Controller_Action $controller,$modelClass,$deleteFunction,$successMessage,$errorMessage,$redirector=array("index")){
		$id = $controller->getParam("id");
		if($id):
			$model = new $modelClass();
			$result = $model->$deleteFunction($id);
			if($result):
				$controller->getHelper("flashMessenger")->addMessage("$successMessage");
			else:
				$controller->getHelper("flashMessenger")->addMessage("$errorMessage");
			endif;
		else:
			$controller->getHelper("flashMessenger")->addMessage("Nothing to delete");
		endif;
		call_user_func_array(array($controller->getHelper("redirector"),"direct"), $redirector);
	}	
}
?>