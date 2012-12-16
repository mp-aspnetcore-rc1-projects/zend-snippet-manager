<?

/**
 * permet de logger des informations diffusée par un serveur de log
 */
class CMS_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

  public function preDispatch(Zend_Controller_Request_Abstract $request) {
    //set up ACL
    $acl = new Zend_Acl();
    //roles
    $acl->addRole(new Zend_Acl_Role("guest"));
    $acl->addRole(new Zend_Acl_Role("user"), "guest");
    $acl->addRole(new Zend_Acl_Role("administrator"), "user");
    // add the resources
    $acl->add(new Zend_Acl_Resource('index'));
    $acl->add(new Zend_Acl_Resource('error'));
    $acl->add(new Zend_Acl_Resource('api'));
    $acl->add(new Zend_Acl_Resource('account'));
    $acl->add(new Zend_Acl_Resource('snippet'));
    $acl->add(new Zend_Acl_Resource('category'));
    $acl->add(new Zend_Acl_Resource("bug"));
    $acl->add(new Zend_Acl_Resource("menu"));
    $acl->add(new Zend_Acl_Resource("menu-item"));
    $acl->add(new Zend_Acl_Resource("test"));
    $acl->add(new Zend_Acl_Resource("dojo"));
    $acl->add(new Zend_Acl_Resource("rest"));
    $acl->add(new Zend_Acl_Resource("search"));
    //$acl->add(new Zend_Acl_Resource("rest:index"),"rest");
    // regles
    $acl->allow(null, array('index', "error"));
    $acl->allow('guest', 'account', array("register", "confirm", "login", "render-login-menu","exist"));
    $acl->allow('guest', "snippet", array("index", "show"));
    $acl->allow('guest',array("rest"));
    $acl->allow('guest', "api", array("getloginform","getcategories", "getallsnippets", "getusercredentials", "getusermenu", "searchsnippet"));
    $acl->allow('user', "api", array("togglefavoritesnippet","savesnippet", "deletesnippet", "favoritesnippet","logout","getsnippetform"));
    $acl->allow('user', "snippet", array("create", "delete", "update"));
    $acl->allow('user', "account", array("logout", "show"));
    $acl->allow("administrator", null);

    // obtenir le role de l'utilisateur
    $auth = Zend_Auth::getInstance();
    if ($auth->hasIdentity()) {
      $identity = $auth->getIdentity();
      $role = strtolower($identity->role);
    } else {
      $role = "guest";
    }
    // vérifier l'autorisation d'access du role à une resource.
    $controller = $request->controller;
    $action = $request->action;
    if (!$acl->isAllowed($role, $controller, $action)) {
      if ($role == 'guest') {
        $request->setControllerName('account');
        $request->setActionName('login');
      } else {
        $request->setControllerKey("error");
        $request->setActionName("noauth");
      }
    }
    Zend_Registry::set("acl", $acl);
  }

}
