<?php
	class AuthController extends IController{
		public function registerAction(){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$login = trim(strip_tags($_POST['login']));
				$pass = md5(md5(trim(strip_tags($_POST['pass']))));
				$email = trim(strip_tags($_POST['email']));
				$utime = time();
				if(!empty($login) and !empty($pass) and !empty($email)){
					$r = $this->do_true_action(self::MUsers, 'addUser', array($login, $pass, $email, time()-3600*24, $utime));
					if($r){
						$this->transporter->end_work(__CLASS__, 'r1');
					}else{
						$this->transporter->end_work(__CLASS__, 'r2');
					}
				}
			}
		}
		public function loginAction(){
			if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['login-form'])){
				if(!empty($_POST['login']) and !empty($_POST['pass'])){
					$login = trim(strip_tags($_POST['login']));
					$pass = md5(md5(trim(strip_tags($_POST['pass']))));
					$user = $this->do_true_action(self::MUsers, 'getUser', array($login, $pass));
					if($user){
						$key = md5(microtime().rand(1000,100000));
						setcookie('uid',$user['uid'],time()+3600*24*30,'/');
						setcookie('key',$key,time()+3600*24*30,'/');
						$this->do_true_action(self::MUsers, 'set_key', array($user['uid'], $key));
						header('Location:/');
						exit;
					}else{
						$this->transporter->end_work(__CLASS__, 'l1');
					}
				}else{
					$this->transporter->end_work(__CLASS__, 'l2');
				}
			}
		}
		public function logoutAction(){
			setcookie('uid', '', 1,'/');
			setcookie('key', '', 1,'/');
			$this->user = false;
			header('Location:/');
		}
	}
?>