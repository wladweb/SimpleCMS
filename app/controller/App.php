<?php
	class App{
		private static $instance;
		private $controller, $action, $params = array();
		private function __construct(){
			$this->is_first_start();
			$url = $_SERVER['REQUEST_URI'];
			$url_arr = explode('/', trim($url, '/'));
			if(!empty($url_arr[0])){
				$this->controller = ucfirst($url_arr[0]).'Controller';
				
			}else{
				$this->controller = 'IndexController';
			}
			if(!empty($url_arr[1])){
				$this->action = $url_arr[1].'Action';
				if(isset($url_arr[2])){
					$keys = $values = array();
					for($i = 2, $cnt = count($url_arr);$i < $cnt; $i++){
						if($i % 2 === 0){
							$keys[] = $url_arr[$i];
						}else{
							$values[] = $url_arr[$i];
						}
					}
					if(count($keys) > count($values)){
						array_pop($keys);
					}elseif(count($values) > count($keys)){
						array_pop($values);
					}
					$this->params = array_combine($keys, $values);
				}
			}else{
				$this->action = 'indexAction';
			}
		}
		public static function getInstance(){
			if(!(self::$instance instanceof self)){
				self::$instance = new self;
				return self::$instance;
			}else{
				return self::$instance;
			}
		}
		public function route(){
			if(file_exists('app/controller/'.$this->getController() . '.php')){
				if(class_exists($this->getController())){
					$rfc = new ReflectionClass($this->getController());
					if($rfc->hasMethod($this->getAction())){
						$method = $rfc->getMethod($this->getAction());
						$controller = $rfc->newInstance();
						$method->invoke($controller);
					}else{
						$this->getError();
						exit;
					}
				}else{
					$this->getError();
					exit;
				}
			}else{
				$this->getError();
				exit;
			}
		}
		
		private function getController(){
			return $this->controller;
		}
		private function getAction(){
			return $this->action;
		}
		public function getParams(){
			return $this->params;
		}
		public function getError(){
			$err = new IndexController;
			$err->badRequest();
		}
		protected function is_first_start(){
			$path = $_SERVER['DOCUMENT_ROOT'].'/setup.ini';
			session_start();
			if(!is_file($path)){
				include 'atemplate/please_rename_config_file.php';
				exit;
			}elseif(isset($_SESSION['first_start']) || isset($_COOKIE['bad_close_session'])){
				include 'atemplate/please_input_data.php';
				exit;
			}
			$this->sess_destroy();
		}
		protected function sess_destroy(){
			$_SESSION = array();
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
			session_destroy();
		}
	}
?>