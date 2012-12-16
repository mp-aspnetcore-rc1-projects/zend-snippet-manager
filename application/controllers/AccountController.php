<?php

/**
 * PROCESSUS d'enregistrement
 *
 *
 *
 */
class AccountController extends Zend_Controller_Action {

  /**
   * proxy for the flash messenger
   *
   *
   *
   */
  protected $messages = null;
  protected $registrationSuccess = 'An email was sent to %s at %s , please confirm your account';
  protected $registrationError = 'Something went wrong , cannot create new account';
  protected $userEmailexistsError = 'This account already exists , please use another email / user name';
  protected $confirmationSuccess = 'Your account have been confirmed , please login';
  protected $confirmationError = 'No account found for this key';
  protected $loginSuccess = 'You are successfully logged in ';
  protected $loginError = 'Account not found or not confirmed , try again';

  /**
   *
   * @var Zend_Utils_CrudController
   */
  protected $crudController;

  public function init() {
    //define("DEFAULT_ROLE","user");
    $this->accounts = new Application_Model_DbTable_Account();
    if (Zend_Auth::getInstance()->hasIdentity()):
      $this->account = Zend_Auth::getInstance()->getIdentity();
    endif;
    $this->flashMessenger = $this->messages = $this->_helper->flashMessenger;
    //$this->initView();
    //Zend_Utils_CrudController::init($this,"Account");
    $this->crudController = new Zend_Utils_CrudController();
    $this->crudController->init($this, "Accounts");
    //@NOTE @ZEND retourner du json pour existAction
    $contextSwitch = $this->getHelper("contextSwitch");
    $contextSwitch->addActionContext("exist", array("json"))->initContext("json");
  }

  public function indexAction() {
    $this->crudController->showAll("accounts", $this->accounts, "fetchAll");
    $this->view->subtitle = "Manage accounts";
  }

  /** check if a username or a email already exists during the resgistration process * */
  public function existAction() {
    $username = $this->getRequest()->getParam("username");
    $email = $this->getRequest()->getParam("email");
    if ($username) {
      $this->accounts->findAccountByUsername($username) && $this->view->exists = true;
    } elseif ($email) {
      $this->accounts->findAccountByEmail($email) && $this->view->exists = true;
    }
  }

  public function createAction() {
    $form = new Application_Form_FormAccount();
    $createAccountId = $this->crudController->create($form, $this->accounts, "create", "New account was created successfully", "Error cannot create  account");
    if ($createAccountId) {
      $confirmed = $this->accounts->confirm($createAccountId);
    }
  }

  public function updateAction() {
    $form = new Application_Form_FormAccount();
    $form->removeElement("password");
    $form->removeElement("password_confirm");
    $this->crudController->update($form, $this->accounts, "updateInfos", "Account updated", "Error updating account");
  }

  public function deleteAction() {
    $this->crudController->delete($this->accounts, "deleteItem", "Account deleted", "Error deleting account");
  }

  /**
   * montre le formulaire de login
   * authentifie l'utilisateur
   *
   *
   *
   */
  public function loginAction() {
    $form = new Application_Form_FormLogin();
    if ($this->getRequest()->isPost()):
      if ($form->isValid($_POST)):
        if ($this->getHelper("authenticate")->direct($form->getValidValues())):
          //$account = $accounts->findUserByUsernameOrEmail($form->email);
          $this->messages->addMessage($this->loginSuccess);
          $this->getHelper("redirector")->direct("index", "snippet");
        else:
          // $this->messages->addMessage($this->loginError);
          $this->_helper->flashMessenger->addMessage($this->loginError);
          $this->_helper->redirector("login");
        endif;
      endif;
    endif;
    $this->view->form = $form;
  }

  /**
   * logout
   */
  public function logoutAction() {

    Zend_Auth::getInstance()->clearIdentity();
    $this->_helper->flashMessenger->addMessage('You are now logged out of you account');
    $this->redirect($this->view->baseUrl());
  }

  /**
   * show registration form
   *
   *
   *
   */
  public function registerAction() {
    $form = new Application_Form_FormRegister();
    $this->view->registerForm = $form;
    // if POST
    if ($this->_request->isPost()):
      // if POST datas are valid
      if ($form->isValid($this->_request->getPost())):
        $registration = $this->_registerUser($form->getValues());
        if ($registration):
          $this->view->registerForm = "thank you.";
        endif;
        // redirige vers le même controlleur pour afficher les messages du flashmessenger
        $this->getHelper("redirector")->direct("register", "account");
      endif;
    endif;
  }

  /**
   * confirme un compte
   * redirige vers la page de login
   *
   *
   *
   */
  public function confirmAction() {
    // action body
    $key = $this->_request->getParam('key');
    // si clef
    if ($key != null):
      $account = new Application_Model_DbTable_Account();
      $result = $account->findAccountByRegistrationKey($key);
      if ($result != null):
      else:
        $this->messages->addMessage($this->confirmationError);
      endif;
    endif;
    $this->messages->addMessage($this->confirmationSuccess);
    $this->redirect("/account/login");
  }

  /**
   * FR : complete le processus d'enregistrement , mÃ©thode indÃ©pendante pour
   * permettre l'appel via ajax , par exemple
   * EN : complete registration process
   * @param array $user_datas
   * @return boolean returns true if no errors in the process
   *
   *
   *
   */
  protected function _registerUser(array $user_datas) {
    $account = new Application_Model_DbTable_Account();
    $result = $account->findUserByUsernameOrEmail($user_datas["username"], $user_datas["email"]);
    // is not a username associated with ?
    if (!$result):
      try {
        //try to create an account , for the user role
        $user_datas['role'] = "user";
        $accountCreated = $account->create($user_datas);
        // EN : if new user inserted
        if ($accountCreated != null):
          $newAccount = $account->find($accountCreated)->current();
          // envoyer un mail de confirmation
          $this->_helper->sendMail(Zend_Mail::getDefaultFrom(), $newAccount->email, $newAccount->username, "Snippet manager : Confirm your Account", "please navigate to that url to confirm the email {$this->view->serverUrl("/account/confirm/key/")}{$newAccount->recovery}");
          $this->messages->addMessage(sprintf($this->registrationSuccess, $newAccount->username, $newAccount->email));
          // forward to another controller
          return $newAccount;
        endif;
      } catch (Exception $exc) {
        $this->messages->addMessage($this->registrationError);
        $this->messages->addMessage($exc->getTraceAsString());
      }
    // EN : if user already exists
    else:
      $this->messages->addMessage($this->userEmailexistsError);
    endif;
  }

  protected function _authenticate($data) {
    $db = Zend_Db_Table::getDefaultAdapter();
    $authAdapter = new Zend_Auth_Adapter_DbTable($db);
    $authAdapter->setTableName("accounts");
    $authAdapter->setIdentityColumn("email");
    $authAdapter->setCredentialColumn("password");
    $authAdapter->setIdentity($data['email']);
    $authAdapter->setCredential(md5($data['pswd']));
    $authAdapter->setCredentialTreatment('confirmed = 1');
    $auth = Zend_Auth::getInstance();
    $result = $auth->authenticate($authAdapter);
    if ($result->isValid()):
      $account = $authAdapter->getResultRowObject();
      if ($account->confirmed != 1) {
        $auth->clearIdentity();
        return false;
      }
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

  public function renderLoginMenuAction() {
    $auth = Zend_Auth::getInstance();
    $this->view->account = $auth->getIdentity();
  }

  public function showAction() {
    if ($this->account == null):
      $this->getHelper("flashMessenger")->addMessage("no account found");
      $this->getHelper("redirector")->direct("index", "snippet");
    else:
      $user_id = $this->account->id;
      $accounts = new Application_Model_DbTable_Account();
      $account = $accounts->find($user_id)->current();
      if ($account):
        $this->view->account = $account;
      else:
        $this->getHelper("flashMessenger")->addMessage("no account found");
        $this->getHelper("redirector")->direct("index", "snippet");
      endif;
    endif;
  }

}

