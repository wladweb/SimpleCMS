<?php
	class EditpostsController extends IController{
		protected $tpl;
		public function indexAction(){
			$this->is_admin();
			if(!empty($this->params['pst'])){
				$this->post_start = $this->params['pst'];
			}else{
				$this->post_start = 0;
			}
			$this->tpl = 'posts';
			$this->count_data = $this->do_true_action(self::MBloginfo, 'get_menu_count_data');
			$this->cats = $this->do_true_action(self::MCategory, 'get_all_categories');
			$this->posts = $this->do_true_action(self::MPosts, 'get_posts', array((int)$this->post_start, (int)$this->pagination));
			$this->posts_count = array_pop($this->posts);
			$this->get_atemplate();
		}
		protected function get_pagination(){
			$arr_page_links = parent::get_pagination($this->posts_count);
			echo '<h3 class="pag-title">Страницы</h3><ul class="pagination">';
			$anchor=1;
			$page = $this->post_start/$this->pagination;
			foreach($arr_page_links as $l){
				if($page+1 === $anchor){
					echo "<li class='active'>";
				}else{
					echo "<li>";
				}
				echo "<a href='/editposts/index/pst/$l'>$anchor</a></li>";
				$anchor++;
			} 
			echo '</ul>';
		}
		public function addAction(){
			$this->is_admin();
			$this->tpl = 'add_post';
			$this->cats = $this->do_true_action(self::MCategory, 'get_categories');
			$this->count_data = $this->do_true_action(self::MBloginfo, 'get_menu_count_data');
			$this->get_atemplate();
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$title = trim(strip_tags($_POST['title']));
				$subtitle = trim(strip_tags($_POST['subtitle']));
				$img = trim(strip_tags($_POST['img']));
				$cat = trim(strip_tags($_POST['category']));
				$content = trim(strip_tags($_POST['content']));
				$author = $this->user['uname'];
				$ctime = date('d-m-y H:i:s',time());
				$r = $this->do_true_action(self::MPosts, 'add_post', array($title, $subtitle, $img, $cat, $content, $author, $ctime));
				if($r){
					$this->transporter->end_work(__CLASS__, 'a1');
				}else{
					$this->transporter->end_work(__CLASS__, 'a2');
				}
			}
		}
		public function delAction(){
			$this->is_admin();
			$r = $this->do_true_action(self::MPosts, 'delete_post', array($this->params['pid']));
			$this->do_true_action(self::MComments, 'delete_comments_by_post', array($this->params['pid']));
			if($r){
				$this->transporter->end_work(__CLASS__, 'd1');
			}else{
				$this->transporter->end_work(__CLASS__, 'd2');
			}
		}
		public function updateAction(){
			$this->is_admin();
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$pid = abs((int)$_POST['pid']);
				$title = trim(strip_tags($_POST['title']));
				$subtitle = trim(strip_tags($_POST['subtitle']));
				$category = trim(strip_tags($_POST['category']));
				$img = trim(strip_tags($_POST['img']));
				$content = trim(strip_tags($_POST['content'], '<em><a><h1><h1><h2><h3><h4><h5><h6><img><p><strong><table><tr><td><th><sub><sup>'));
				$r = $this->do_true_action(self::MPosts, 'update_post', array($pid, $title, $subtitle, $category, $img, $content));
				if($r){
					$this->transporter->end_work(__CLASS__, 'u1');
				}else{
					$this->transporter->end_work(__CLASS__, 'u2');
				}
			}else{
				$this->transporter->end_work(__CLASS__, 'u2');
			}
		}
	}
?>