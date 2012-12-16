<?php

class Application_Form_TestForm extends Zend_Form
{

	public $crudForm;
	
    public function init()
    {
        $this->crudForm = new Zend_Utils_CrudForm($this,"Application_Model_DbTable_Test");
        $this->crudForm->render();
        //$this->crudForm->render()->info();
        
    }


}

