<?php

//namespace Entity;
use Phalcon\Mvc\Model;


class Causa extends Model{

  protected $idAreaAtendimento;
  protected $idPartecontraria;
//  public $relato;

  public function initialize(){
    $this->hasOne('idAreaAtendimento','AreaAtendimento','id');
    $this->hasOne('idPartecontraria','ParteContraria','id');
  }
}
