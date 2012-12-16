<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->getHelper("redirector")->direct("index","snippet","default");
    }

    public function showAction()
    {
        echo APPLICATION_PATH;
        echo $_SERVER["REQUEST_URI"];
    }

    public function helpAction()
    {
      $this->view->title = $this->view->translate("Help"); 
    }

    public function aboutAction()
    {
      $this->view->title = $this->view->translate("About");
    }


}


