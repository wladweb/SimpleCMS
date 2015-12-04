<?php

namespace SimpleCMS;

use SimpleCMS\Application\App;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Content-Type: text/html; charset=utf-8');
require 'vendor/autoload.php';
/*
set_include_path(get_include_path() .
        PATH_SEPARATOR . 'app/model' .
        PATH_SEPARATOR . 'app/view' .
        PATH_SEPARATOR . 'app/controller' .
        PATH_SEPARATOR . 'app');

function simple_loader($name) {
    $arr_names = explode('\\', $name);
    $class = end($arr_names);
    require_once "$class.php";
}

\spl_autoload_register('SimpleCMS\simple_loader');
*/

$app = App::getInstance();
$app->route();
