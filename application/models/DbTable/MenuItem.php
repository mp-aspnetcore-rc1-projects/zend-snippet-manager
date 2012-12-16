<?php

class Application_Model_DbTable_MenuItem extends Zend_Db_Table_Abstract
{

	protected $_name = 'menu_items';
	protected $_rowClass = 'Application_Model_DbTable_MenuItemRow';
	protected $_referenceMap=array(
	'Menu'=>array(
		'columns'=>array("menu_id"),
		"refTableClass"=>'Application_Model_DbTable_Menu',
		"refColumns"=>array('id'),
		"onDelete"=>self::CASCADE,
		"onUpdate"=>self::RESTRICT
	)
	);
	
	function createItem($datas){
		$menuItem = $this->createRow();
		$menuItem->setFromArray($this->adapt($datas));
		$id = $menuItem->save();
		return $id;
	}
	
	function updateItem($datas){
		$menuItem = $this->find($datas['id'])->current();
		if($menuItem):
			$menuItem->setFromArray($this->adapt($datas));
			return $menuItem->save();
		endif;
	}
	
	/** filtre les clefs du paramètre $datas et retourne un tableau compatible avec la table de la row à modifier*/
	function adapt($datas){
		$result = array();
		$result['label'] = $datas["label"];
		$result['menu_id'] = $datas["menu_id"];
		$result['link'] =$datas["link"];
		$result['page_id'] = $datas["page_id"];
		$result['action'] = $datas["action"];
		$result['position'] = $datas["position"];
		return $result;
	}
	
	function getItemsByParentId($menu_id,$order=array("position","label")){
		return  $this->fetchAll($this->_createQuery(array("menu_id"=>$menu_id),$order));
	}
	
	function getAllItems($order=array("menu_id","position")){
		return $this->fetchAll($this->_createQuery(array(),$order));
	}
	
	function getItem($id){
		return $this->find($id)->current();

	}
	 
	protected function _createQuery($where=array(),$order=array()){
	 	$select = $this->select();
	 	foreach($where as $column => $value):
	 		$select->where(" $column = ? ",$value);
	 	endforeach;
	 	foreach($order as $column):
	 		$select->order($column);
	 	endforeach;
	 	return $select;
	 }

}

