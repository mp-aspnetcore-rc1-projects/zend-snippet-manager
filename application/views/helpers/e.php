<?php

class Zend_View_Helper_E extends Zend_View_Helper_Abstract {

  public function e($data) {
   $this->view->escape($data);
  }

}
