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
        '../models/'
    )
)->register();



$di = new FactoryDefault();

$di->set('db', function(){
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "root",
            "dbname"   => "cidadao"
        ));
    });



$app=new Micro($di);

$app->get('/pessoas',function(){
    $pessoas=Pessoa::find();
  //  $json[]= $pessoas->jsonSerialize();
    echo json_encode($pessoas->toArray());
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

$app->handle();
