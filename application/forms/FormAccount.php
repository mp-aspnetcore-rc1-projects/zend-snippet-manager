<?php

class Application_Form_FormAccount extends Application_Form_FormRegister {

  public function init() {
    $roles = array("user" => "user", "administrator" => "administrator");
    $this->addElements(
            array(
                "role" => array(
                    "type" => "select",
                    "name" => "role",
                    "options" => array(
                        "label" => "Role*",
                        "required" => true,
                        "multiOptions" => $roles
                    )
                )
            )
    );
    parent::init();
    $this->removeElement("captcha");
    $this->setName("account_form");
  }

}

