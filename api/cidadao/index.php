<?php

use Phalcon\Mvc\Micro;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Loader;
use Phalcon\Http\Response;

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

$app->handle();
