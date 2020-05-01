<?php
/*
* cette classe permet d'apeler la bonne action
*/

class ApiController extends Controller{

  private $_action;
  private $_params;

  public function __construct($action, $params){
    $this->setAction($action);
    $this->setParams($params);
    $action = $this->loadAction();
  }

  private function setParams($params){
    $this->_params = $params;
  }

  private function setAction($action){
    $this->_action = $action;
  }

  private function loadAction(){
    $name = ucfirst($this->_action);
    $file = ROOT.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$name.'.php';
    require_once($file);
    return new $name($this->_params);
  }

}