<?php

class Application_Model_DbTable_Favorite extends Zend_Db_Table_Abstract {

  protected $_name = 'favorites';
  protected $_primary = "id";
  protected $_referenceMap = array(
    'Accounts' => array(
      'columns' => "user_id",
      "refTableClass" => "Application_Model_DbTable_Account",
      "refColumns" => "id"
    ),
    "Snippets" => array(
      'columns' => "snippet_id",
      "refTableClass" => "Application_Model_DbTable_Snippet",
      "refColumns" => "id"
    )
  );

  public function getFavoritesByUserId($id) {
    $query = $this->select();
    $query->where(" user_id = ? ", $id);
    $result = $this->fetchAll($query);
    return $result;

  }

  public function getUserFavoritesList($id) {
    $result = array();
    $favorites = $this->getFavoritesByUserId($id);
    foreach ($favorites as $favorite):
      $result[] = $favorite->snippet_id;
    endforeach;
    return $result;
  }
  


}

