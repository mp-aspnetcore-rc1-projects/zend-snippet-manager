<?php

class Application_Form_FormCategory extends Zend_Form {

  public function init($options = null) {
    parent::init();
    $elements = array(
        "title"=>array("name"=>"title","type"=>"text","options"=>array("size"=>100,"label"=>"Title","required"=>true)),
        "description"=>array("name"=>"description","type"=>"textarea","options"=>array("cols"=>77,"rows"=>5,"label"=>"Description","required"=>true)),
        "reset"=>array("name"=>"reset","type"=>"reset"),
        "submit"=>array("name"=>"submit","type"=>"submit","options"=>array("required"=>true)),
        "id"=>array("name"=>"id","type"=>"hidden","options"=>array("required"=>true)),
        "antiforgery"=>array("name"=>"antiforgery","type"=>"hash","options"=>array("required"=>true))
    );
    $this->setName('category');
    $this->addElements($elements);
  }

}
