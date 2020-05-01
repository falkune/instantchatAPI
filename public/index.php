<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");

define('WEBROOT', dirname(__FILE__)); // correspond au chemin du dossier public
define('ROOT', dirname(WEBROOT)); // correspond au chemin du dossier principale
define('CORE', ROOT.DIRECTORY_SEPARATOR.'core'); // corresspon au chemin du dossier core

require_once(CORE.DIRECTORY_SEPARATOR.'includes.php');

spl_autoload_register('chargerClass');

new Dispatcher();
