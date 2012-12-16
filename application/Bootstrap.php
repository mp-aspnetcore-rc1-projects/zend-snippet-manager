<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

  protected function _initViewParams() {

    $this->bootstrap('view');
    $view = $this->getResource("view");

    ZendX_JQuery::enableView($view);
    //Zend_Dojo::enableview($view);
  }

  protected function _initConfig() {
    $config = new Zend_Config($this->getOptions());
    Zend_Registry::set('config', $config);
    return $config;
  }

  protected function _initApplicationHelpers() {
    if (!function_exists("generateID")) {

      function generateID() {
        return md5(time() . md5(time()));
      }

    }
    if (!function_exists("removeDecorators")) {

      function removeDecorators($context = null) {
        if ($context != null):
          foreach ($context->getElements() as $element):
            $element->removeDecorator("DtDdWrapper")
                ->removeDecorator("label")
                ->removeDecorator("htmlTag");
          endforeach;
        endif;
      }

    }
  }

  protected function _initHelpers() {
    Zend_Controller_Action_HelperBroker::addPrefix("Daome_ActionHelpers");
  }

}

