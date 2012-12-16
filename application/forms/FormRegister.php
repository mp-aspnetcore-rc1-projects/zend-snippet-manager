<?php

class Application_Form_FormRegister extends Zend_Form {

 public function init() {
   
   
  $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
   
  defined("DEFAULTSIZE")|| define("DEFAULTSIZE", 50);

  $this->setName("registration-form");
  $this->addElements(
    array(
      "username" => array(
        "type" => "text",
        "name" => "username",
        "options" => array(
          "label" => "Username*",
          "required" => true,
          "size" => DEFAULTSIZE,
          "validators" => array('Alnum',(array("validator"=>"stringLength","options"=>array(5,100))))
        )
      ),
      "email" => array(
        "label" => "email",
        "type" => "text",
        "name" => "email",
        "validator" => "emailAddress",
        "options" => array(
          "label" => "Email*",
          "required" => true,
          "validators" => array("emailAddress"),
          "size" => DEFAULTSIZE
        )
      ),
      "password" => array(
        "type" => "password",
        "name" => "password",
        "options" => array(
          'label' => "Password*",
          "size" => DEFAULTSIZE,
          "required" => true,
          "validators" => array("Alnum")
        )
      ),
      "password_confirm"=>array(
        "type"=>"password",
        "name"=>"password_confirm",
        "options"=>array(
          "label"=>"Confirm password*",
          "required"=>true,
          "size"=>DEFAULTSIZE,
          "validators"=>array("Alnum",array("validator"=>"stringMatch","options"=>array("password")))
        )
      ),
      "zip" => array(
        "type" => "text",
        "name" => "zip",
        "options" => array(
          "label" => "Country",
          //                      "required" => true,
          "size" => DEFAULTSIZE,
          "validators" => array("Alnum"),
        )
      ),
      "captcha"=>array(
        "type"=>"captcha",
        "name"=>"captcha",
        "options"=>array(
          "label"=>"captcha",
          "required"=>true,
          "captcha"=>array(
            "captcha"=>"Image",
            "wordLen"=>6,
            "timeout"=>300,
            'dotNoiseLevel' => 25, // Valeur initiale = 100
            'lineNoiseLevel' => 2, // Valeur initiale = 5
            'font' => APPLICATION_PATH . '/../public/fonts/Freeroad.ttf',
            'fontSize' => 20,
            'imgDir' => APPLICATION_PATH . '/../public/captcha',
            'imgUrl' => $baseUrl.'/captcha/',
          )
        )
      ),
      "anti-forgery"=>array(
        "type"=>"hash",
        "name"=>"anti_forgery"

        )
      ,
      "submit" => array(
        "type" => "submit",
        "name" => "submit",
        "options" => array(
          "required" => true
        )
      ),
      "reset" => array(
        "type" => "reset",
        "name" => "reset"
      )
    )
  );

 }

}

