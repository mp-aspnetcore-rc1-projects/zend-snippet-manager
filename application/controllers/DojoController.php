<?php

/**
 * Exemple d'utilisation de DOJO Dijits (dojo widgets)
 * avec Zend Framework
 */
class DojoController extends Zend_Controller_Action {

  /**
   *
   * @var Application_Model_DbTable_Snippet
   */
  protected $snippet_table;



  public function init() {
    //$this->view->init();
    $this->getHelper("layout")->setLayout("layout-snippet-manager");
    $this->view->title = "Dojo Tests";
    Zend_Dojo::enableView($this->view);
    $this->view->dojo()->setDjConfigOption('usePlainJson', true)
            ->addStylesheetModule('dijit.themes.tundra')
            //->setDjConfigOption("parseOnLoad", true)
            //->addStylesheet('/js-src/dojox/grid/_grid/tundraGrid.css')
            //->setLocalPath('/js/dojo/dojo.js')
            //->addLayer('/js/paste/main.js')// custom code
            //->addJavascript('paste.main.init();')
            ->disable(); // enable only when necessary
    $this->snippet_table = new Application_Model_DbTable_Snippet();
    $_cs = $this->_helper->getHelper("contextSwitch");

  }

  public function indexAction() {

  }

  public function createsnippetAction() {
    $snippetDojoForm = new Application_Form_SnippetDojoForm();
    $this->view->snippetDojoForm = $snippetDojoForm;
  }

  public function listsnippetsAction(){
    $snippets = $this->snippet_table->fetchAll();
    $this->view->snippets = $snippets;
  }

}

