<?php
/*
*cette classe recupere le tableau parser par le routeur
*il va s'en servir pour appeler le bon controlleur.
*/
class Dispatcher{
 
  private $_request;

  public function __construct(){
    $this->_request = new Request();
    Router::parse($this->_request->url(), $this->_request);
    $controller = $this->loadController();
  }

  public function loadController(){
    $name = ucfirst($this->_request->controller).'Controller';
    $file = ROOT.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$name.'.php';
    require_once($file);
    return new $name($this->_request->action, $this->_request->params);
  }

}