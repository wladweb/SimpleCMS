<?php

namespace SimpleCMS;

use SimpleCMS\Application\App;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

$app = App::getInstance();
$app->route();


