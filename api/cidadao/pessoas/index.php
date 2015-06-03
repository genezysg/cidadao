<?php

use Phalcon\Mvc\Micro;

$app=new Micro();


$app->get('/pessoas',function(){
    $pessoa=array(array(
    "nome"=>"genezys",
    "nacionalidade"=>"brasileiro",
  ),
  array(
    "nome"=>"matheus",
    "nacionalidade"=>"brasileiro",)
  );
    echo json_encode($pessoa);
});

$app->handle();
