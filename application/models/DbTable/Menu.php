<?php

class Application_Model_DbTable_Menu extends Zend_Db_Table_Abstract
{

	protected $_name = "menus";
	protected $_dependentTables = array('Application_Model_DbTable_MenuItem');
	protected $_referenceMap = array(
		'Menu'=>array(
	      "columns"=>array("parent_id"),
	      "refTableClass"=>"Application_Model_DbTable_Menu",
	      "refColumns"=>array("id"),
	      "onDelete"=>self::CASCADE,
	      "onUpdate"=>self::RESTRICT
		)
	);
	
	function getAllItems(){
		$menus = $this->fetchAll();
		return $menus;
	}
	
	function getItem($id){
		$menu = $this->find($id)->current();
		return $menu;
	}
	function createItem($datas){
		$menu = $this->createRow();
		$menu->name =$datas["name"];
		$menu->access_level = $datas["access_level"];
		$result = $menu->save();
		return $result;
	}
	
	function updateItem(array $datas){
		$menu = $this->find($datas["id"])->current();
		$menu->name = $datas["name"];
		$menu->access_level=$datas["access_level"];
		$result = $menu->save();
		return $result;
		
	}
	
	function deleteItem($id){
		$menu = $this->find($id)->current();
		if($menu):
			$result = $menu->delete();
		return $result;
		endif;
	}

}

