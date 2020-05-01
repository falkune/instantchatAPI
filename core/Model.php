<?php
class Model{

  private $_db = 'default';

  public function __construct(){

  }

  public function connexion(){

    $conf = Conf::$databases[$this->_db];
    
    try{
      return $error = new PDO('mysql:host='.$conf['host'].';dbname='.$conf['database'], $conf['login'], $conf['password'], array(PDO::ATTR_ERRMODE	=>PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $e){
      die($e->getMessage());
    }

  }

}



