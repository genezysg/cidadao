<?php

//namespace Entity;
use Phalcon\Mvc\Model;


class Causa extends Model{

  protected $idAreaAtendimento;


  public function initialize(){
    $this->hasOne('idAreaAtendimento','areaatendimento','id');
  }
}
