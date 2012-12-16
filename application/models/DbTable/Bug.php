<?php

class Application_Model_DbTable_Bug extends Zend_Db_Table_Abstract {

  protected $_name = 'bugs';

  function createBug($datas) {
    $row = $this->createRow();
    $row->author = $datas["author"];
    $row->email = $datas["email"];
    $row->url = $datas["url"];
    $row->description = $datas["description"];
    $row->priority = $datas["priority"];
    $row->status = $datas["status"];
    $row->created = date("U");
    $row->save();
    $id = $this->getAdapter()->lastInsertId();
    return $id;
  }

  function listBugs($filters = array(), $sortField = null, $limit = null, $page = 1) {
    $query = $this->select();
    // filtres pour la clause where
    if (count($filters) > 0):
      foreach ($filters as $key => $value) :
        $query->where(" $key LIKE ? ", "%$value%");
      endforeach;
    endif;
    // sort order
    if (null != $sortField):
      $query->order($sortField);
    endif;
    return $this->fetchAll($query)->toArray();
  }

  function fetchPaginatorAdapter($filters = array(), $sortField = null) {
    $select = $this->select();
    if (count($filters > 0) && is_array($filters)):
      foreach ($filters as $key => $value) {
        $select->where(" $key like ?", "%$value%");
      }
    endif;
    if (null != $sortField):
      $select->order($sortField);
    endif;
    $adapter = new Zend_Paginator_Adapter_DbSelect($select);
    return $adapter;
  }

  function deleteBug($id) {
    if ($id) {
      $where = $this->getAdapter()->quoteInto(" id = ? ", $id);
      $result = $this->delete($where);
      return $result;
    }
  }

  function updateBug($datas = null, $id = null) {
    if ($datas && $id):
      $row = $this->find($id)->current();
      $row->author = $datas["author"];
      $row->email = $datas["email"];
      $row->url = $datas["url"];
      $row->description = $datas["description"];
      $row->priority = $datas["priority"];
      $row->status = $datas["status"];
      $result = $row->save();
      return $result;
    endif;
  }

}

