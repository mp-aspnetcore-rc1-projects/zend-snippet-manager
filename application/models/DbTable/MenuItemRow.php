<?php

class Application_Model_DbTable_MenuItemRow extends Zend_Db_Table_Row_Abstract{
	protected $_name = "menu_items";
	protected $_parentTable = "Application_Model_DbTable_Menu";
	
	function getParentItem(){
		return $this->findParentRow($this->_parentTable);
	}
}
?>