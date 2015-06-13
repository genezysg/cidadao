<?php



use Phalcon\Mvc\Controller;


class CausaController extends Controller{


public function getAll(){
  $value = Causa::find();
  echo json_encode($value->toArray());
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
