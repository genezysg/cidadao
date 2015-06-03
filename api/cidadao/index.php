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
    $pessoa=array(array(
    "nome"=>"genezys",
    "nacionalidade"=>"brasileiro",
  ),
  array(
    "nome"=>"matheus",
    "nacionalidade"=>"brasileiro",)
  );
    $pessoas=Pessoa::find();
    echo json_encode($pessoa);
});

$app->handle();
