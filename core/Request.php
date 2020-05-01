<?php
/*
*cette classe permet de recuperer l'url de l'utilisateur
*/
class Request{

  private $_url;

  public function __construct(){
    $this->_url = $_SERVER['PATH_INFO'];
  }

  public function url(){
    return $this->_url;
  }

}