<?

class Daome_ActionHelpers_Initializer extends Zend_Controller_Action_Helper_Abstract {
  /* function __construct() {
    $this->pluginLoader = new Zend_Loader_PluginLoader();
    } */

  // méthode executée quand le helper est appelé
  /* function direct() {
    $auth = Zend_Auth::getInstance();
    // vérifie si un utilisateur est loggé
    if ($auth->hasIdentity()):
    $identity = $auth->getIdentity();
    $accounts = new Application_Model_DbTable_Account();
    $account = $accounts->findAccountByEmail($identity);
    if ($account):
    // créer une variable account dans la vue.
    Zend_Layout::getMvcInstance()->getView()->account = $account;
    endif;
    endif;
    } */
  function __construct() {
    $this->pluginLoader = new Zend_Loader_PluginLoader();
    $auth = Zend_Auth::getInstance();
    // vérifie si un utilisateur est loggé
    if ($auth->hasIdentity()):
      $identity = $auth->getIdentity();
      $accounts = new Application_Model_DbTable_Account();
      $account = $accounts->findAccountByEmail($identity->email);
      if ($account):
        // créer une variable account dans la vue.
        
        Zend_Layout::getMvcInstance()->getView()->account = $account;
      endif;
    endif;
  }

}
