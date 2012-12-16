<?php

class Application_Model_DbTable_Account extends Zend_Db_Table_Abstract {

 protected $_name = 'accounts';
 protected $_primary = 'id';
 protected $_dependentTables = array('Application_Model_DbTable_Favorite', 'Application_Model_DbTable_Snippet');

 /**
  *
  * @var Zend_Utils_CrudModel
  */
 protected $crudModel;

 function init() {
  parent::init();
  $this->crudModel = new Zend_Utils_CrudModel($this, array($this,"adapt"));
 }

 /**
  * FR : trouve un user par son nom ou son email
  * @param $name String
  * @param $email String
  * @return Zend_Db_Table_Row_Abstract|null The row results per the
  *     Zend_Db_Adapter fetch mode, or null if no row found.
  */
 function findUserByUsernameOrEmail($name, $email) {
  $query = $this->select();
  if($sname) $query->where(" username like ? ", $name);
  if($email) $query->orWhere(" email like ? ", $email);
  $query->limit(1);
  $result = $this->fetchRow($query);
  return $result;
 }

 function findAccountByEmail($email) {
  $query = $this->select();
  $query->where(" email like ? ", $email);
  $query->limit(1);
  return $this->fetchRow($query);
 }

 function findAccountByUsername($username) {
  $query = $this->select();
  $query->where("username like ?", $username);
  $query->limit(1);
  return $this->fetchRow($query);
 }

 function create(array $array) {
  if($this->findUserByUsernameOrEmail($array["username"], $array["email"])){
   return false;
  }
  // @NOTE @ZEND mapper les valeurs de $array à un tableau donné
  function getAccountData($array) {
   return array(
     "username" => $array["username"],
     "email" => $array["email"],
     "zip" => $array["zip"],
     "password" => md5($array["password"]),
     "created" => time(),
     "updated" => time(),
     "recovery" => generateID(),
     "role" => $array["role"],
     "confirmed" => 0,
   );
  }

  $accountDatas = getAccountData($array);
  return $this->insert($accountDatas);
 }

 public function register(array $datas){
  //@TODO créer une fonction register différente de la fonction create
 }

 public function findAccountByRegistrationKey($key) {
  $account = $this->fetchRow($this->select()->where(" recovery = ? ", $key));
  if ($account):
  $account->confirmed = 1;
  $account->recovery = "";
  var_dump($account->toArray());
  $this->update($account->toArray(), " id = $account->id ");
  return $account;
  endif;
  return null;
 }

 public function findUserFavorites($user_id) {
  $row = $this->find($user_id)->current();
  $query = $this->select();
  $query->where(" snippet.private = 0 ");
  $query->orWhere(" snippet.user_id = ? ", $user_id);
  $favorites = $row->findManyToManyRowset("Application_Model_DbTable_Snippet", "Application_Model_DbTable_Favorite");
  return $favorites;
 }

 public function confirm($user_id){
  $account = $this->find($user_id)->current();
  if($account!=null){
   $account->confirmed = 1;
   return $account->save();
  }
 }

 public function block($user_id){
  $account=$this->find($user_id)->current();
  if($account!=null){
   $account->confirmed = -1;
   return $account->save();
  }
 }

 public function  deleteItem($id){
  return $this->crudModel->deleteItem($id);
 }
 public function updateInfos($datas,$id){
  return $this->crudModel->updateItem($datas, $id);
 }

 public function adapt(array $datas){
  return array(
    "username"=>$datas["username"],
    "email"=>$datas["email"],
    "zip"=>$datas["zip"],
    "updated"=>time(),
    "role"=>$datas["role"],
  );
 }
}