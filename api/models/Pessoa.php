<?php

//namespace Entity;
use Phalcon\Mvc\Model;


class Pessoa extends Model{
//;
  public $filiacao;
  public function initialize(){
    $this->hasOne('filiacao_id','Filiacao','id');
  }

  public function getJsonContent(){
    $this->filiacao=$this->getFiliacao();
  }
}
