<?

class Zend_Controller_Action_Helper_SendMail extends Zend_Controller_Action_Helper_Abstract {

  function __construct() {
    $this->pluginLoader = new Zend_Loader_PluginLoader();
  }

  // méthode executée quand le helper est appelé
  function direct($fromEmail, $toEmail, $toName, $subject, $body) {
    // envoyer un mail de confirmation
    $mail = new Zend_Mail();
    $mail->setFrom($fromEmail);
    $mail->addTo($toEmail, $toName);
    $mail->setSubject($subject);
    $mail->setBodyText($body);
    $mail->send();
  }

}