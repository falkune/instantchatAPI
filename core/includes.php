<?php
require_once(ROOT.DIRECTORY_SEPARATOR.'config/Conf.php');
function chargerClass($className){
  require $className.'.php';
}