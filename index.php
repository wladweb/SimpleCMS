<?php
	
	header('Content-Type: text/html; charset=utf-8');
	
	set_include_path(get_include_path() . PATH_SEPARATOR . 'app/model' . PATH_SEPARATOR . 'app/view' . PATH_SEPARATOR . 'app/controller');
	
	function __autoload($class){
		require_once "$class.php";
	}
	
	$app = App::getInstance();
	$app->route();
	
?>