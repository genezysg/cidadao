<?php


use Phalcon\Mvc\Model;



class AreaAtendimento extends Model{
  public $id;
  public function getSource(){
		return "areaatendimento";
	}

}
