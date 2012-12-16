<?

/**
 * @NOTE @ZEND gerer des themes , ou skins � l'aide d'un fichier de configuration XML
 */
class Zend_View_Helper_Grid extends Zend_View_Helper_Abstract {

  // cette fonction sera appell� � l'appel du HELPER , elle porte le m�me nom que la class

  public $head = "";
  public $body = "";
  public $table = "";

  /**
   *
   * FR : Génere un tableau
   * prend en paramètre un objet du type :
   * array(
   *  'head'=>array("key1"=>"label1","key2"=>"label2"),
   *  "body"=>array(array("key1"=>"value","key2"=>"value"),
   *    array("key1"=>"value1","key2"=>"value2")
   *  ),
   *  "extraColumns"=>array(
   *    array("label"=>"label of col","content"=>"content of col{{title}} {{id}}")
   *  )
   * );
   * @param array $params
   * @return string
   */
  public function grid($params) {

    // @ZEND @NOTE callback de la fonction de remplacement
    // cherch {{w}} , retourne w
    function callback($match) {
      global $item;
      return htmlentities($item[$match[2]]);
    }

    $params != null && $this->params = $params;
    if (is_array($this->params["head"])):
      $this->head = "<thead><tr>";
      foreach ($this->params["head"] as $key => $value):
        $this->head.="<th>$value</th>";
      endforeach;
      if (isset($this->params["extraColumns"]) && is_array($this->params["extraColumns"])):
        foreach ($this->params["extraColumns"] as $extraColumn):
          $this->head.="<th>$extraColumn[label]</th>";
        endforeach;
      endif;
      $this->head .="</tr></thead>";
    endif;
    //var_dump($this->params["body"]);
    if (isset($this->params["body"])):
      $this->body = "<tbody>";
      foreach ($this->params["body"] as $cell):
        $this->body.="<tr>";
        foreach ($cell as $key => $value):
          if (is_array($this->params["head"])):
            if (array_key_exists($key, $this->params["head"])):
              $this->body.="<td class='$key'>".htmlentities($value)."</td>";
            endif;
          else:
            $this->body.="<td class='$key'>{${htmlentities($value)}}</td>";
          endif;
        endforeach;
        if ( isset($this->params["extraColumns"]) && is_array($this->params["extraColumns"])):
          foreach ($this->params["extraColumns"] as $column):
            global $item;
            $item = $cell;
            /* $result = eval('return "' . $column["content"].'";');
              $this->body.= "<td>$result</td>"; */
            # @NOTE @PHP @ZEND utiliser les expressions régulières.
            $result = preg_replace_callback("/({{)(\w+)(\}\})/", "callback", $column['content']);
            //var_dump($result);
            $this->body.= "<td>$result</td>";
          endforeach;
        endif;
        $this->body.="</tr>";
      endforeach;
      $this->body.="</tbody>";
    endif;
    $this->table = "<table class='grid' >$this->head$this->body</table>";
    return $this->table;
  }
  

}
