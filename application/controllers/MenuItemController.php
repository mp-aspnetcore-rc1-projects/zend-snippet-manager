<?php

class MenuItemController extends Zend_Controller_Action
{

    public function init()
    {
       Zend_Utils_CrudController::init($this,"Menu item");
    }

    /**
     * affiche la liste des menu items
     */
    public function indexAction()
    {
    	$showAllFunction = "getAllItems";
    	$functionArguments=array();
        $menu_id = $this->getParam("menu_id");
        $menu_id!=null AND $showAllFunction = "getItemsByParentId" AND $functionArguments = array($menu_id,array("menu_id"));
        $menuItems = Zend_Utils_CrudController::showAll($this, "menuItems", "Application_Model_DbTable_MenuItem", $showAllFunction,$functionArguments);
		$menu_id!=null AND count($menuItems)>0 AND $this->view->subtitle = "Show menu items from : ".$menuItems->current()->getParentItem()->name;
    }

    /**
     * creer un nouveau menu item
     */
    public function createAction()
    {
        $menu = Zend_Utils_CrudController::create($this, "Application_Form_FormMenuItem", "Application_Model_DbTable_MenuItem", "createItem", "Menu item created", "Error creating menu item");
    }

    /**
     * met a jour un menu item
     */
    public function updateAction()
    {
    	$menuItem = Zend_Utils_CrudController::update($this, "Application_Form_FormMenuItem","Application_Model_DbTable_MenuItem", "updateItem", "Menu item updated", "Error updating menu item",array("show","menu-item",null,array("menu_id"=>$this->getParam("menu_id")) ) );
    }

    /**
     * efface un menu item 
     */
    public function deleteAction()
    {
        Zend_Utils_CrudController::delete($this, "Application_Model_DbTable_MenuItem", "deleteItem", "Menu item deleted", "Error deleting menu item");
    }

    /**
     * montre le détail d'un menu item 
     */
    public function showAction()
    {
        $menuItem = Zend_Utils_CrudController::show($this, "menuItem", "Application_Model_DbTable_MenuItem", "getItem", "", "Menu item not found");
    }

    public function renderAction()
    {
   
    }


}











