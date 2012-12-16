<?php

class Application_Model_DbTable_Snippet extends Zend_Db_Table_Abstract {

  protected $_dependentTables = array('Application_Model_DbTable_Favorite');
  // nom de la table associÃ©e dans la base de donnÃ©e
  protected $_name = 'snippets';
  // associer la class SnippetRow Ã  un model d'enregistrement donnÃ©
  protected $_rowClass = 'Application_Model_DbTable_SnippetRow';
  // tables dont la table courante est dÃ©pendante.
  protected $_referenceMap = array(
    'Category' => array(
      'columns' => array('category_id'),
      'refTableClass' => 'Application_Model_DbTable_Category'
    ),
    "Account"=>array(
      'columns'=>array("user_id"),
      "refTableClass"=>"Application_Model_DbTable_Account"
    )
  );

  function init() {
    parent::init();
  }

  function searchByCategoryId($id = null) {
    if ($id != null) {
      $result = $this->fetchAll(array("category_id = {$this->getAdapter()->quoteIdentifier($id)}"));
      return $result;
    }
  }

  function searchByCategoryName($category = null) {
    $categoryTable = new Application_Model_DbTable_Category();
    $query = $categoryTable->select();
    if ($category != null) {
      $query->where("title LIKE ?", $category);
    }
    $result = $categoryTable->fetchRow($query);
    if ($result != null) {
      // la mï¿½thode mise en parenthï¿½se fonctionne aussi.
      // $snippets = $result->findDependentRowset('Application_Model_DbTable_Snippet');
      $snippets = $result->findApplication_Model_DbTable_Snippet();
    }

    return $snippets;
  }

  function create(array $datas) {
    $datas =$this->adapt($datas);
    $datas["created"]=time();
    $snippet = $this->createRow();
    $snippet->setFromArray($datas);
    $result = $snippet->save();
    return $result;
  }

  /** alias **/
  function createItem(array $datas){
    return $this->create($datas);
  }

  function updateItem(array $datas,$id) {
    $snippet = $this->find($id)->current();
    $snippet->setFromArray($datas);
    $result = $snippet->save();
    return $result;
  }
  function destroy($id) {
    $where = $this->getAdapter()->quoteInto(" id = ? ", $id);
    $this->delete($where);
  }

  /** alias **/
  function deleteItem($id){
    return $this->destroy($id);
  }

  /**
   * 
   * @param array $where
   * @param array $order
   * @param int $limit
   * @param int $offset
   * @return Zend_Db_Table_Rowset_Abstract
   */
  function getAll($category_id=null,$user_id=null,$account_id=null,$account_role=null,$term=null){
    $select = $this->select();
    if($category_id){
      $select->where("category_id = ? ",$category_id);
    }

    if($user_id){
      $select->where("user_id = ? ",$user_id);
    }

    if($term):
      $select->where(" title LIKE ? ","%$term%");
    endif;

    if($account_role && $account_role!="administrator"){

      $select->where("private = 0 ");
      $select->orWhere(" private = 1 AND user_id = ?",$account_id);

    }elseif($account_role==null){

      $select->where("private = 0 ");

    }
    $select->order("created DESC");
    return $this->fetchAll($select);

  }
  

  function getAllItemsByUserId($id){

  }

  public function findByTitle($title) {
    $query = $this->select()->where(" title like ?", $title);
    return $this->fetchRow($query);
  }

  public function deleteSnippet($id) {
    $where = $this->getAdapter()->quoteInto(" id = ?", $id);
    return $this->delete($where);
  }

  public function belongsToUser($id, $user_id) {
    $query = $this->select()->where(" id =  ? ",$id)->where(" user_id = ? ",$user_id)->limit("1");
    $snippet = $this->fetchRow($query);
    return $snippet;
  }

  /*@NOTE @ZEND filtrer les données de manière a retourner seulement les clefs requises*/
  public function adapt(array $datas){
    $result = array("title" => $datas["title"],
      "content" => $datas["content"],
      "description" => $datas["description"],
      "category_id"=>$datas["category_id"],
      "user_id"=>$datas["user_id"],
      "private"=>$datas["private"],
      "updated" => time()
    );
    return $result;
  }
}

