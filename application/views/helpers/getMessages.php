<?php

class Zend_View_Helper_GetMessages extends Zend_View_Helper_Abstract {

  public function getMessages(array $messages = null) {
    if ($messages == null):
      return;
    endif;
    foreach ($messages as $message):
      echo "<p>$message</p>";
    endforeach;
  }

}
