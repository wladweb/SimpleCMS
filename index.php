<?php
	
namespace SimpleCMS;

use SimpleCMS\Application\App;
use PDO;
	header('Content-Type: text/html; charset=utf-8');
	
	set_include_path(get_include_path() .
                PATH_SEPARATOR . 'app/model' .
                PATH_SEPARATOR . 'app/view' . 
                PATH_SEPARATOR . 'app/controller'.
                PATH_SEPARATOR . 'app');
	
	function simple_loader($name){
            $arr_names = explode('\\', $name);
            $class = end($arr_names);
            require_once "$class.php";
	}
	\spl_autoload_register('SimpleCMS\simple_loader');
        
	$app = App::getInstance();
	$app->route();
	