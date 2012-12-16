<?php

class Application_Form_FormMenuItem extends Zend_Form
{
    public function init()
    {
    	$size =100;
    	$model_menu = new Application_Model_DbTable_Menu();
    	$menus = $model_menu->getAllItems();
    	$menuOptions=array();
    	foreach ($menus as $menu):
    		$menuOptions[$menu->id]=$menu->name;
    	endforeach;
       $this->setName("menuItemForm");
       $this->addElements(array(
       	"id"=>array("type"=>"hidden","name"=>"id","options"=>array()),
       	"label"=>array("type"=>"text","name"=>"label","options"=>array("label"=>"Label* :","required"=>true,"size"=>$size)),
       	"menu_id"=>array("type"=>"select","name"=>"menu_id","options"=>array("label"=>"Menu* :", "required"=>true, "multiOptions"=>$menuOptions)),
        "link"=>array("type"=>"text","name"=>"link","options"=>array("label"=>"Link url :", "required"=>false,"size"=>$size)),
        "page_id"=>array("type"=>"text","name"=>"page_id","options"=>array("label"=>"Page id :" ,"required"=>false,"size"=>$size)),
        "action"=>array("type"=>"text","name"=>"action","options"=>array("label"=>"Action :" ,"required"=>false,"size"=>$size)),
       	"position"=>array("type"=>"text","name"=>"position","options"=>array("label"=>"Position :")),
       	"reset"=>array("type"=>"reset","name"=>"reset","options"=>array()),
       	"submit"=>array("type"=>"submit","name"=>"submit","options"=>array("required"=>true))
       ));
    }
}

