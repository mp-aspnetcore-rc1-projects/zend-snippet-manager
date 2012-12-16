<?php

class Application_Form_FormSnippet extends Zend_Form {

  const DEFAULT_ROWS = 5;
  const SIZE = 100;

  function __construct($options = array()) {
    parent::__construct($options);
    $this->setName('snippet');
    $this->setMethod('post');
    $this->setAction($this->options['action']);
    $categories = $this->getCategoryOptions();
    $this->addElements(array(
        "id" => array(
            "type" => "hidden",
            "name" => "id"
        ),
        "title" => array(
            "type" => "text",
            "name" => "title",
            "label" => "Title",
            "placeholder" => "Snippet title",
            "attributes" => array("placeholder" => "Snippet title"),
            "options" => array("size" => self::SIZE, "label" => "Title", "required" => true
            )
        ),
        "category" => array(
            "type" => "select",
            "name" => "category_id",
            "options" => array("multiOptions" => $categories, "label" => "Category", "required" => true,"filters"=>array("digits"))
        ),
        "description" => array(
            "type" => "text",
            "name" => "description",
            "options" => array("required"=>true, "size" => self::SIZE, "label" => "Description")
        ),
        "private"=>array(
           "type"=>"checkbox",
          "name"=>"private",
          "options"=>array("checkedValue"=>"1","label"=>"Private","required"=>false)
          ),
        "content" => array(
            "type" => "textarea",
            "name" => "content",
            "options" => array("rows" => $this->DEFAULT_ROWS, "label" => "Content", "required" => true)
        ),
        "reset" => array(
            "type" => "reset",
            "name" => "reset",
        ),
        "submit" => array(
            "type" => "submit",
            "name" => "submit",
            "options" => array("required" => true)
        ),
      "hash"=>array(
        "type"=>"hash",
        "name"=>"antiforgery",
        "options"=>array("required"=>true)
        )
    ));
  }

  /**
   * Retourne un tableau de catégories ["nom de la category"]=>["id de la categories]
   * @return  array
   */
  protected function getCategoryOptions() {
    $categoryTable = new Application_Model_DbTable_Category();
    $query = $categoryTable->select();
    $query->order(" title ASC ");
    $tempCategories = $categoryTable->fetchAll($query)->toArray();
    $categories = array();
    foreach ($tempCategories as $category):
      $categories[$category["id"]] = $category["title"];
    endforeach;
    return $categories;
  }

}

