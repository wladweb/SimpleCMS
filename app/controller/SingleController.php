<?php
class SingleController extends IController{
	protected $post;
	protected $tpl;
	public function indexAction(){
		$this->get_data();
		if(!empty($this->params['post'])){
			$this->post = $this->do_true_action(self::MPosts, 'get_post', array($this->params['post']));
		}else{
			$this->tpl = '404.php';
			$this->get_template('index.php');
			exit;
		}
		if($this->post !== false){
			$this->comments = $this->do_true_action(self::MComments, 'get_comments', array($this->post['id']));
			$this->post['post_comment_count'] = count($this->comments);
			$this->tpl = 'single-main.php';
			$this->get_template('single.php');
		}else{
			$this->tpl = '404.php';
			$this->get_template('index.php');
			exit;
		}
	}
	public function get_comments(){
		if(!empty($this->comments)){
			include $this->get_template_name().'/comments.php';
		}else{
			echo '<p id="comments" class="comment-mark">Нет комментариев</p>';
		}
	}
	public function get_comment_form(){
		if($this->user){
			include $this->get_template_name().'/comment_form.php';
		}else{
			echo '<p>Для добавления комментария вы должны <a href="">войти</a></p>';
		}
	}
	protected function i_can_vote(){
		if(!$this->vote){
			$this->transporter->end_work(__CLASS__, 'p3');
		}
	}
	public function popularAction(){
		$this->is_user();
		$this->i_can_vote();
		if(empty($this->params['pid'])){
			$this->transporter->end_work(__CLASS__, 'p2');
		}elseif(empty($this->params['pop'])){
			$this->transporter->end_work(__CLASS__, 'p2');
		}else{
			if($this->params['pop'] !== 'p' and $this->params['pop'] !== 'm'){
				$this->transporter->end_work(__CLASS__, 'p2');
			}else{
			
				$current_popular = $this->do_true_action(self::MPosts, 'get_current_popular', array($this->params['pid']))['popular'];
				
				if($this->params['pop'] == 'p'){
					$current_popular++;
				}elseif($this->params['pop'] == 'm'){
					$current_popular--;
				}
				
				$this->do_true_action(self::MPosts, 'set_current_popular', array($current_popular, $this->params['pid']));
				if(isset($_COOKIE['vv'])){
					$cc = $_COOKIE['vv'];
					$cc++;
					setcookie('vv', $cc, time()+$this->vote_interval,'/');
				}else{
					setcookie('vv', 1, time()+$this->vote_interval,'/');
				}
				$this->transporter->end_work(__CLASS__, 'p1');
			}
		}
	}
}
?>
