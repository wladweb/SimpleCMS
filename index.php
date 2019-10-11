<?php

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

if (Wladweb\SimpleCMS\Application::DEBUG) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

Wladweb\SimpleCMS\Application::run();


