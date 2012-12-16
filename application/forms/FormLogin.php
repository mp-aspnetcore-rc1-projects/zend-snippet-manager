<?php

class Application_Form_FormLogin extends Zend_Form {

  public function init($options = null) {
    $this->setName('login');
    $this->setMethod('post');
    //$this->setAction('/public/account/login');
    $email = new Zend_Form_Element_Text('email');
    $email->setLabel("Email");
    $email->setRequired();
    $email->addValidator('emailAddress');
//    $email->setLabel("email");
//    $email->removeDecorator('label')->removeDecorator('htmlTag');
    $pswd = new Zend_Form_Element_Password('pswd');
    $pswd->setLabel("Password");
    $pswd->setRequired();
    $public = new Zend_Form_Element_Checkbox("public");
$public->setLabel("Stay logged ?");
//    $pswd->setLabel("password");
    $submit = new Zend_Form_Element_Submit('submit');
   // $this->setDecorators(array(array('ViewScript',
      //  array('viewScript' => 'forms/_form_login.phtml'))));

    /*$captcha = new Zend_Form_Element_Captcha("captcha",
            array(
              "label" => "captcha",
              "required" => true,
              "class"=>array(
                "captcha"
              ),
              "captcha" => array(
                "captcha" => "Image",
                "wordLen" => 6,
                "timeout" => 300,
                'dotNoiseLevel' => 25, // Valeur initiale = 100
                'lineNoiseLevel' => 2, // Valeur initiale = 5
                'font' => APPLICATION_PATH . '/../public/fonts/Freeroad.ttf',
                'fontSize' => 20,
                'imgDir' => APPLICATION_PATH . '/../public/captcha',
                'imgUrl' => '/captcha/',
              )
            )
    );*/
    //$captcha->setAttrib("required","required");
    $hash = new Zend_Form_Element_Hash("hash");
    $hash->setRequired();
    $this->addElements(array($email, $pswd, $public,/* $captcha,*/ $hash,$submit));
  //  removeDecorators($this);
  }

}
