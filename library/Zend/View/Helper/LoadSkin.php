<?
/**
 * @NOTE @ZEND gerer des themes , ou skins � l'aide d'un fichier de configuration XML
 */
class Zend_View_Helper_LoadSkin extends Zend_View_Helper_Abstract{

  // cette fonction sera appell� � l'appel du HELPER , elle porte le m�me nom que la class
  public function loadSkin($skin){
    
    // @NOTE @ZEND charger une configuration depuis un fichier XML vwww. 
    //$skinData = new Zend_Config_Xml("./skins/$skin/skin.xml");
    $skinData = new Zend_Config_Xml(APPLICATION_PATH."/../public/skins/$skin/skin.xml");
    // recuperer la liste de stylesheets dans un tableau
    $stylesheets = $skinData->stylesheets->stylesheet->toArray();
    if(is_array($stylesheets)):
      foreach($stylesheets as $stylesheet):
        // pour chaque stylesheet trouv� , ajout� aux stylesheets du layout
        // echo $stylesheet;
        // @NOTE @ZEND appeler la vue � partir d'un view helper
        $this->view->headLink()->appendStylesheet($this->view->baseUrl("/skins/$skin/css/$stylesheet"));
      endforeach;
    endif;
    return $this->view->headLink();
  }
}
