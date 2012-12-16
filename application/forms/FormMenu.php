<?php

class Application_Form_FormMenu extends Zend_Form
{

	public function init()
	{
		$access_levels =array(
		"guest"=>"guest",
    	"user"=>"user",
    	"administrator"=>"administrator"
		);
		$this->setName("menuForm");
		$this->addElements(array(
        "id"=>array("type"=>"hidden","name"=>"id","options"=>array()),
        "name"=>array("type"=>"text","name"=>"name","options"=>array("size"=>100,"label"=>"Name","required"=>"true")),
        "access_level"=>array("type"=>"select","name"=>"access_level","options"=>array("label"=>"Access level","required"=>true,"multiOptions"=>$access_levels)),
		"reset"=>array("type"=>"reset","name"=>"reset","options"=>array()),
		"submit"=>array("type"=>"submit","name"=>"submit","options"=>array("required"=>true)),
		"anti_forgery"=>array("type"=>"hash","name"=>"anti_forgery","options"=>array("required"=>true))
		));
		

	}


}

