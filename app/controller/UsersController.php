<?php
	class UsersController extends IController{
		protected $tpl;
		public function indexAction(){
			$this->is_admin();
			if(!empty($this->params['pst'])){
				$this->post_start = $this->params['pst'];
			}else{
				$this->post_start = 0;
			}
			$this->count_data = $this->do_true_action(self::MBloginfo, 'get_menu_count_data');
			$this->users_data = $this->do_true_action(self::MUsers, 'get_all_users', array((int)$this->post_start, (int)$this->pagination));
			$this->users_count = array_pop($this->users_data);
			$this->tpl = 'users';
			$this->get_atemplate();
		}
		protected function get_pagination(){
			$arr_page_links = parent::get_pagination($this->users_count);
			echo '<h3 class="pag-title">Страницы</h3><ul class="pagination">';
			$anchor=1;
			$page = $this->post_start/$this->pagination;
			foreach($arr_page_links as $l){
				if($page+1 === $anchor){
					echo "<li class='active'>";
				}else{
					echo "<li>";
				}
				echo "<a href='/users/index/pst/$l'>$anchor</a></li>";
				$anchor++;
			} 
			echo '</ul>';
		}
		public function editAction(){
			$this->is_user();
			$this->tpl = 'single_user';
			$this->user['coment_count'] = $this->do_true_action(self::MComments, 'get_comments_count_by_user', array($this->user['uid']))['coment_count'];
			$this->count_vote = $this->get_count_vote();
			$this->get_atemplate();
		}
		protected function get_count_vote(){
			if(isset($_COOKIE['vv']) and $_COOKIE['vv'] < $this->vote_limit){
				return $this->vote_limit - $_COOKIE['vv'];
			}else{
				$last_vote_time = $this->do_true_action(self::MUsers, 'get_last_vote_time', array($this->user['uid']))['last_vote'];
				if($last_vote_time+$this->vote_interval < time()){
					return $this->vote_limit;
				}else{
					$waiting = round(($last_vote_time+$this->vote_interval - time())/60);
					return 'Вы сможете голосовать через: '. $waiting .' минут.';
				}
			}
		}
		public function updateAction(){
			$this->is_user();
			$email = trim(strip_tags($_POST['email']));
			$pass1 = trim(strip_tags($_POST['pass']));
			$pass2 = trim(strip_tags($_POST['passagain']));
			if(
			(empty($email)) or 
			(empty($pass1) and !empty($pass2)) or 
			(!empty($pass1) and empty($pass2)) or 
			($pass1 !== $pass2)){
				$this->transporter->end_work(__CLASS__, 'u2');
			}
			if(empty($pass1) and empty($pass2)){
				$r = $this->do_true_action(self::MUsers, 'update_user', array($this->user['ukey'], $email));
				if($r){
					$this->transporter->end_work(__CLASS__, 'u1');
				}else{
					$this->transporter->end_work(__CLASS__, 'u3');
				}
			}else{
				$pass = md5(md5($pass1));
				$r = $this->do_true_action(self::MUsers, 'update_user', array($this->user['ukey'], $email, $pass));
				if($r){
					$this->transporter->end_work(__CLASS__, 'u1');
				}else{
					$this->transporter->end_work(__CLASS__, 'u3');
				}
			}
			
		}
		public function delAction(){
			$this->is_admin();
			$r = $this->do_true_action(self::MUsers, 'delete_user', array($this->params['u']));
			$this->do_true_action(self::MComments, 'delete_comments_by_user', array($this->params['u']));
			if($r){
				$this->transporter->end_work(__CLASS__, 'd1');
			}else{
				$this->transporter->end_work(__CLASS__, 'd2');
			}
		}
	}
?>