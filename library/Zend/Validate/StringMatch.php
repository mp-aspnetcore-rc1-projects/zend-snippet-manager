<?php

class Zend_Validate_StringMatch extends Zend_Validate_Abstract{
 const NOT_MATCH = "notMatch";
 protected $_messageTemplates = array(
   self::NOT_MATCH => "Confirmation does not match the orginial"
 );

 public function __construct($options=null){
  is_array($options) && $this->fieldName = $options[0];
  is_string($options)&& $this->fieldName = $options;
  isset($options) || $this->fieldName = "password_confirm";
 }
 
 public function isValid($value,$context=null,$options=null){
  $value = (string)$value;
  $this->_setValue($value);
  if(is_array($context)){
   if(isset($context[$this->fieldName])
     && $value==$context[$this->fieldName])
     {
      return true;
     }
  }elseif(is_string($context)&&($value==$context)){
   return true;
  }
  $this->_error(self::NOT_MATCH);
  return false;
 }

}