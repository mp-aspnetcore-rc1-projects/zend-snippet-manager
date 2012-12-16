<?php

class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract
{
  // table associ�e au model
  protected $_name = 'categories';
  // clef primaire 
  protected $_primary = "id";
  // d�finie une d�pendance vers une table qui possede l'id de 
  // la cat�gorie en clef �trang�re.
  protected $_dependentTables = array('Application_Model_DbTable_Snippet');
  function getAllItems(){
    $select =$this->select();
    $select->order(" title ASC ");
    return $this->fetchAll($select);
  }
}

