<?php



use Phalcon\Mvc\Controller;


class CausaController extends Controller{


public function getAll(){
  $causasfound = Causa::find();
//  $causasfound->AreaAtendimento;
  foreach ($causasfound as $causa){
      $causa->AreaAtendimento;
      //cria array de causas
      $causas[]=$causa;
  }
  echo json_encode($causas);
}

public function post(){
  $value=$this->request->getJsonRawBody();
  $value->hue="worked";
  echo json_encode($value);
}

public function getOne($id){
  echo json_encode("hue".$id);
}

}
