<?php

class Rest_Bootstrap extends Zend_Application_Module_Bootstrap {

//  protected function _initRestRoute() {
//    $this->bootstrap('Request');
//    $front = $this->getResource('FrontController');
//    $restRoute = new Zend_Rest_Route($front, array(), array(
//          'rest' => array(
//            'index'
//          )
//        ));
//    $front->getRouter()->addRoute('routeIndex', $restRoute);
//  }

  protected function _initRestRoute() {
    $this->bootstrap('frontController');
    $frontController = Zend_Controller_Front::getInstance();
    $restRoute = new Zend_Rest_Route($frontController,array(),array("rest"));
    $frontController->getRouter()->addRoute('rest_route', $restRoute);
  }

}
