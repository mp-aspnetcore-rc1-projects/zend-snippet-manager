<?php

class Application_Form_FormFilterBug extends Zend_Form {

  public function init() {
    parent::init();
    $this->setName("FormFilterBug");
    $this->setTranslator(Zend_Registry::get("Zend_Translate"));
    $options = array(
        "0" => "None",
        "priority" => "Priority",
        "status" => "Status",
        "created" => "Date",
        "url" => "Url",
        "author" => "Author"
    );
    $this->addElements(array(
        "sort" => array(
            "type" => "select",
            "name" => "sort",
            "options" => array(
                "multiOptions" => $options,
                "label" => "Sort reports : ",
            )
        ),
        "field" => array(
            "type" => "select",
            "name" => "field",
            "options" => array(
                "multiOptions" => $options,
                "label" => "Filter field : "
            )
        ),
        "filter" => array(
            "type" => "text",
            "name" => "filter",
            "options" => array(
                "label"=>"Filter value : ",
                "title"=>"filter value",
                "size" => 20
            )
        ),
        "submit" => array(
            "type" => "submit",
            "name" => "submit"
        )
    ));
  }

}

