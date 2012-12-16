<?php

/**
 * Ajoute des méthodes à chaque ligne(Row) d'un dataset de la table snippets
 */
class Application_Model_DbTable_SnippetRow extends Zend_Db_Table_Row_Abstract {

  protected $_name = 'snippets';
  public $favorite = '1';

  /** obtient le nom de la categorie du snippet
   * grace à la colonne category_id de la table snippets
   */
  function __construct(array $config = array()) {
    parent::__construct($config);
    //$this->category_name = $this->GetSnippetCategoryName();
  }

  function GetSnippetCategoryName() {
    // obtient une categorie en fonction de l'id
    $category = new Application_Model_DbTable_Category();
    $query = $category->select();
    $query->where(" id = ?", $this->category_id);
    // enregistrement
    $row = $category->fetchRow($query);
    return $row->title;
  }

  function GetAuthorName() {
    $author = $this->findParentRow("Application_Model_DbTable_Account");
    if ($author):
      $result = $author->username;
    else:
      $result = "anonymous";
    endif;
    return $result;
  }

  public function belongsToUser($user_id) {
    if ($this->user_id == $user_id):
      return true;
    endif;
  }

}

