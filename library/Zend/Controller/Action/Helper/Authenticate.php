<?php

/**
 * @NOTE @ZEND creer un action helper
 */
class Zend_Controller_Action_Helper_Authenticate extends Zend_Controller_Action_Helper_Abstract {

  /** la m�thode direct est appel�e quand le controlleur
   * execute $this->_helper->authenticate($datas)
   */
  function direct($data) {
    $db = Zend_Db_Table::getDefaultAdapter();
    $authAdapter = new Zend_Auth_Adapter_DbTable($db);
    $authAdapter->setTableName("accounts");
    $authAdapter->setIdentityColumn("email");
    $authAdapter->setCredentialColumn("password");
    $authAdapter->setCredentialTreatment('confirmed = 1');
    $authAdapter->setIdentity($data['email']);
    $authAdapter->setCredential(md5($data['pswd']));
    $auth = Zend_Auth::getInstance();
    $result = $auth->authenticate($authAdapter);
    if ($result->isValid()):
      $account = $authAdapter->getResultRowObject();
      if ($account->confirmed != 1) {
        $auth->clearIdentity();
        return false;
      }
      // regarde si l'utilisateur veut rester loggé ou pas
      if ($data['public'] == "1"):
        Zend_Session::rememberMe(1209600);
      else:
        Zend_Session::forgetMe();
      endif;
      $storage = $auth->getStorage();
      $storage->write($authAdapter->getResultRowObject(array('id', 'username', 'email', 'role')));
      return TRUE;
    else:
      return FALSE;
    endif;
  }

}
