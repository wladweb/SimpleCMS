<?php
	class IndexController extends IController{
		protected $tpl;
		public function indexAction(){
			$this->get_data();
			if(!empty($this->params['pst'])){
				$this->post_start = $this->params['pst'];
			}else{
				$this->post_start = 0;
			}
			$this->posts = $this->do_true_action(self::MPosts, 'get_posts',array((int)$this->post_start, (int)$this->pagination));
			$this->posts_count = array_pop($this->posts);
			foreach($this->posts as &$p){
				$p['content'] = mb_substr($p['content'], 0, $this->preview_character_count, 'utf-8').'...';
			}
			
			$this->tpl = 'main.php';
			$this->get_template('index.php');
		}
		public function badRequest(){
			$this->get_data();
			$this->tpl = 'error.php';
			$this->get_template('index.php');
		}
		public function get_pagination(){
			$arr_page_links = parent::get_pagination($this->posts_count);
			if(!empty($arr_page_links)){
				echo '<h3>Страницы</h3><ul>';
				$anchor=1;
				foreach($arr_page_links as $l){
					$current = '';
					if($l == $this->post_start){
						$current = 'class="current"';
					}
					echo "<li $current><a href='/index/index/pst/$l'>$anchor</a></li>";
					$anchor++;
				} 
				echo '</ul>';
			}
			
		}
	}
?>