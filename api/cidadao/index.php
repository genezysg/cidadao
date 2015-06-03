<?php

use Phalcon\Mvc\Micro;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Loader;
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
   $pessoa=new Pessoa();
   $pessoa->id=$id;
   foreach ($json as $key=>$value){
     $pessoa->{$key}=$value;
   }
   $pessoa->save();
   echo json_encode($pessoa);
});

$app->handle();
