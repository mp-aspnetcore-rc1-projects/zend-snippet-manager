<?php

/**
 * creer un formulaire en fonction du model.
 */
class Zend_Utils_CrudForm{

	/**
	 * @var Zend_Form
	 */
	public $context ;

	/**
	 * @var Zend_Db_Table_Abstract
	 */
	public $model;
	
	/**
	 * Faire correspondre un type de donnée avec un type de champs de formulaire
	 * @var array
	 */
	public $elementTypes = array(
				"integer"=>"text",
				"varchar"=>"text",
				"text"=>"textarea",
				"datetime"=>"DatePicker",
				"default"=>"text"
			);
	
	public $defaultRows = 10;
	public $defaultCols = 63;
	public $defaultSize = 80;
	
	function __construct(Zend_Form $context,$modelClass){
		$this->context=$context;
		$this->model = new $modelClass();
		ZendX_JQuery::enableForm($this->context);
	}

	/**
	 * execute le rendu du formulaire.
	 */
	function render(){
		$infos = $this->model->info();
		$this->context->setName("$infos[name]_form");
			foreach ($infos["metadata"] as $key => $value):
			if($key==$infos["primary"][1]):
				$element = $this->context->createElement("hidden", $key);
			else:
				$type  = $this->elementTypes[$value['DATA_TYPE']];
				$element = $this->context->createElement($type, $key);
				$required =	! $key['NULLABLE'];
				$element->setOptions(array("cols"=>$this->defaultCols, "size"=>$this->defaultSize,"rows"=>$this->defaultRows,"label"=>"$key"));
				$element->setRequired($required);
				$key['DEFAULT']!=null AND $element->setValue("$key[DEFAULT]");
			endif;
				$this->context->addElement($element);
				
			endforeach;
		$this->context->addElements(array(
				
				"reset"=>array("name"=>"reset","type"=>"reset"),
				"submit"=>array("name"=>"submit","type"=>"submit","options"=>array("required"=>true)),
				"hash"=>array("type"=>"hash","name"=>"hash","options"=>array("required"=>true))
 	));
		/*$infos=array(
				$this->model->info(),
				$this->model->getDefinition(),

		);
		for($i=0;$i<count($infos);$i++):
			var_dump($infos[$i]);
		endfor;*/
		return $this;
	}
	
	function info(){
		//var_dump($this->model->info());
	}
}
