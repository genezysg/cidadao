<?php



use Phalcon\Mvc\Controller;


class CausaController extends Controller{


public function getAll(){
  echo json_encode("hue");
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
