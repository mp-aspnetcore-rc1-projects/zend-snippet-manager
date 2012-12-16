

  # jQuery helper , obtenir les donn�es d'un formulaire sous forme de  { clef : valeur , ... }
 

  $.fn.serializeToArray =  ->
      result = {}
      datas = this.serializeArray()
      for i in datas
        result[i.name] = i.value
      return result

