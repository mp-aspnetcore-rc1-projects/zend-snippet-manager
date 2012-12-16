<?php

/** 
 * fonctions facilitant l'acces aux données du model
 * @author mark prades
 */
class Zend_Utils_CrudModel{

	/**
	 * @var Zend_Db_Table_Abstract
	 */
	protected $context;
	/**
	 * @var array|string must be a valid callback
	 */
	protected $adapterCallback;
	protected $id_column = "id";
	
	/**
	 * Constructeur
	 * @param Zend_Db_Table_Abstract $context
	 * @param string|array $adapterCallback
	 */
	function __construct( Zend_Db_Table_Abstract $context,$adapterCallback){
		$this->setContext($context);
		$this->adapterCallback = $adapterCallback;
	}
	
	/** 
	 * défini le context
	 * @param Zend_Db_Table_Abstract $context
	 */
	protected function setContext($context){
		$this->context = $context;
	}
	
	/**
	 * obtient le context
	 * @return Zend_Db_Table_Abstract $context
	 */
	protected function getContext(){
		return $this->context ;
	}

	/**
	 * défini le nom de la clef primaire
	 * @param string $name
	 */
	protected function setIdColumn($name){
		$this->id_column=$name;
	}
	
	/**
	 * retourne le nom de la clef primaire
	 * @return string
	 */
	protected function getIdColumn(){
		return $this->id_column;
	}
	
	/**
	 * Obtient des items
	 * @param array $where
	 * @param array $order
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	function getAll(array $where=array(),array $order=array()){
		return $this->context->fetchAll($where,$order);
	}

	/** 
	 * obtient un item
	 * @param string $id
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, multitype:>
	 */
	function getItem($id){
		return $this->context->find($id)->current();
	}

	/**
	 * met à jour un item
	 * @param array $datas
	 * @param unknown_type $id
	 */
	function updateItem(array $datas,$id){
		$row = $this->context->find($id)->current();
		if($row):
			$adaptedDatas = call_user_func($this->adapterCallback,$datas);
			$row->setFromArray($adaptedDatas);
			$result = $row->save();
		endif;
		return $result;
	}

	/** 
	 * efface un item
	 * @param string $id
	 * @return int
	 */
	function deleteItem($id){
		$row = $this->context->find($id)->current();
		if($row):
			$result =$row->delete();
		endif;
		return $result;
		
	}
	
	/**
	 *	creer un item
	 * @param array $data
   *  les données à enregister
   * @param array $appendedDatas
   *  les données à passer à l'adapteur
	 * @return string
	 */
	function createItem($data,$appendedDatas){
		$row = $this->context->createRow();
		if(is_callable($this->adapterCallback)):
			$adaptedDatas = call_user_func($this->adapterCallback,$data,$appendedDatas);
		else:
			throw new Exception("not a valid callback");
		endif;
		$row->setFromArray($adaptedDatas);
		$result = $row->save();
		return result;
	}
}
