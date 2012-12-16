<?php

class Application_Form_FormBug extends Zend_Form {
  /*
   * create table bugs(
    id integer primary key not null,
    author varchar(255) default null,
    email varchar(255) default null,
    created date default null,
   * updated date default null,
    url varchar(255) default null,
    description text,
    priority varchar(255) default null,
    status varchar(255) default null
    );
   */

  public function init() {
    $this->setName("FormBug");
    define("SIZE",70);
    define("COLS",53);
    $priorityMultiOptions = array(
        "low" => "Low",
        "med" => "Medium",
        "high" => "High"
    );
    $statusMultiOptions = array(
        "new" => "New",
        "in_progress" => "In Progress",
        "resolved" => "Resolved"
    );
    $elements = array(
        "author" => array("name" => "author",
            "type" => "text",
            "options" => array("size"=>SIZE,"label" => "Author*", "required" => true)
        ),
        "email" => array("name" => "email",
            "type" => "text",
            "options" => array("size"=>SIZE,"label" => "Email*", "required" => true, "validators" => array("EmailAddress")),
            "filters"=>array("StringTrim","StringToLower")
        ),
        "url" => array("name" => "url",
            "type" => "text",
            "options" => array("size"=>SIZE,"label" => "Url", "required" => false)
        ),
        "description" => array("name" => "description",
            "type" => "textarea",
            "options" => array("label" => "Description*","cols"=>COLS,"rows"=>5, "required" => true)
        ),
        "priority" => array("name" => "priority",
            "type" => "select",
            "options" => array("label" => "Priority*", "required" => true, "multiOptions" => $priorityMultiOptions)
        ),
        "status" => array("name" => "status",
            "type" => "select",
            "options" => array("label" => "Status*", "required" => true,"multiOptions"=>$statusMultiOptions)
        ),
        "reset" => array("name" => "reset", "type" => "reset"),
        "submit" => array("name" => "submit", "type" => "submit", "options" => array("required" => true)),
        "hash" => array("name" => "hash", "type" => "hash", "options" => array("required" => true))
    );
    $this->addElements($elements);
  }

}

