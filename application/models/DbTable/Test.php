<?php

class Application_Model_DbTable_Test extends Zend_Db_Table_Abstract {

  protected $_name = 'tests';

  /**
   *
   * @var Zend_Utils_CrudModel
   */
  protected $crudModel;

  function init() {
    parent::init();
    $this->crudModel = new Zend_Utils_CrudModel($this, array($this, "adapter"));
  }

  function getItem($id) {
    return $this->crudModel->getItem($id);
  }

  function getAllItems($where = array(), $order = array()) {
    return $this->crudModel->getAll($where, $order);
  }



  function createItem($data) {
    return $this->crudModel->createItem($data, array("created" => time(), "updated" => time()));
  }

  function updateItem($datas, $id) {
    return $this->crudModel->updateItem($datas, $id);
  }

  function deleteItem($id) {
    return $this->crudModel->deleteItem($id);
  }

  /**
   *
   * @param array $datas
   * @param array $appendedDatas
   * @return array
   */
  function adapter($datas, $appendedDatas = null) {
    $result = array();
    $result["title"] = $datas["title"];
    $result["description"] = $datas["description"];
    if ($appendedDatas != null):
    foreach ($appendedDatas as $key => $value):
    $result[$key] = $value;
    endforeach;
    endif;
    return $result;
  }

}

