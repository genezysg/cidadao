<?php

//namespace Entity;
use Phalcon\Mvc\Model;


class Causa extends Model{

  protected $idAreaAtendimento;
  protected $idPartecontraria;

  public function initialize(){
    $this->hasOne('idAreaAtendimento','areaatendimento','id');
    $this->hasOne('idPartecontraria','partecontraria','id');
  }
}
