<?php

use Phalcon\Mvc\Micro;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Loader;
use Phalcon\Http\Response;

//use Entity\Pessoa;


$loader = new Loader();
$loader->registerDirs(
    array(
        '../models/',
        '../controllers/',
    )
)->register();



$di = new FactoryDefault();

$di->set('db', function(){
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "",
            "dbname"   => "casacidadao",
            'charset' => 'utf8'
        ));
    });



$app=new Micro($di);

include_once "../routes/Routes.php";

$app->get('/pessoas',function(){
  $wtf=Pessoa::find();
//  var_dump($wtf);
  echo json_encode($wtf->toArray());
  //echo json_last_error_msg();
});

$app->get('/pessoas/{id}',function($id){
  $wtf=Pessoa::findFirst($id);
  $wtf->updateFiliacao();
//  var_dump($wtf);
  echo json_encode($wtf);
  //echo json_last_error_msg();
});


$app->put('/pessoas/{id}',function($id) use($app){
   $json=$app->request->getJsonRawBody();
   $pessoa=Pessoa::findFirst($id);
   if (empty($pessoa)){      //echo "Person dont exist";
      $response=new Response();
    //  $response->setContent("Access is not authorized");
      $response->setStatusCode(404,"Not Found");
      return $response;
  } else{
   foreach ($json as $key=>$value){
     $pessoa->{$key}=$value;
   }
   $pessoa->save();
   echo json_encode($pessoa);
 }
});

$app->get('/filiacao',function(){
  $filiacao=Filiacao::find();
  echo json_encode($filiacao->toArray());
});

$app->handle();
