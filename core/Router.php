<?php
/*
*permet de parser une url afin de definir le controlleur, l'action et les paramettre.
*retourne un tableau contenant les parametres paramettres de la route 
*/
class Router{

  static function parse($url, $request){
    $url = trim($url, '/');
    $param = explode('/', $url);
    $request->controller = $param[0];
    $request->action = isset($param[1]) ? $param[1] : 'index';
    $request->params = array_slice($param, 2);
    return $request;
  }

}
