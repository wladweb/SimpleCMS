<?php
	class ImagesController extends IController{
		protected $tpl;
		private $upload_dir = "E:/www/blog/images/";
		private $upload_dir_ava = "E:/www/blog/images/avatars/";
		private $mime_type;
		public function indexAction(){
			$this->is_admin();
			if(!empty($this->params['pst'])){
				$this->post_start = $this->params['pst'];
			}else{
				$this->post_start = 0;
			}
			$this->count_data = $this->do_true_action(self::MBloginfo, 'get_menu_count_data');
			$this->images_data = $this->do_true_action(self::MImages, 'get_all_images', array((int)$this->post_start, (int)$this->pagination));
			$this->count_img = array_pop($this->images_data);
			$this->tpl = 'images';
			$this->get_atemplate();
		}
		protected function get_pagination(){
			$arr_page_links = parent::get_pagination($this->count_img);
			echo '<h3 class="pag-title">Страницы</h3><ul class="pagination">';
			$anchor=1;
			$page = $this->post_start/$this->pagination;
			foreach($arr_page_links as $l){
				if($page+1 === $anchor){
					echo "<li class='active'>";
				}else{
					echo "<li>";
				}
				echo "<a href='/images/index/pst/$l'>$anchor</a></li>";
				$anchor++;
			} 
			echo '</ul>';
		}
		public function uploadAction(){
			$this->check_image();
			if($this->re_save_img()){
				if(move_uploaded_file($_FILES['preview_load']['tmp_name'], $this->upload_dir . $_FILES['preview_load']['name'])){
					$this->do_true_action(self::MImages, 'add_img', array($_FILES['preview_load']['name']));
					$this->transporter->end_work(__CLASS__, 'i1');
				}
			}
		}
		public function avatarAction(){
			$this->check_image();
			if($this->re_save_img()){
				if(move_uploaded_file($_FILES['preview_load']['tmp_name'], $this->upload_dir_ava . $_FILES['preview_load']['name'])){
					$this->do_true_action(self::MImages, 'add_avatar', array($_FILES['preview_load']['name'], $this->user['uid']));
					$this->transporter->end_work(__CLASS__, 'i1');
				}
			}
		}
		protected function check_image(){
			if(!isset($_FILES['preview_load'])){
				$this->transporter->end_work(__CLASS__, 'i2');
			}
			if($_FILES['preview_load']['error'] > 0){
			//ДОПИСАТЬ SWITCH С ОШИБКАМИ
				$this->transporter->end_work(__CLASS__, 'i2');
			}
			$white_list = array('.jpg', '.jpeg', '.png', '.gif');
			$good_image = false;
			foreach($white_list as $item){
				if(preg_match("/$item\$/i", $_FILES['preview_load']['name'])){
					$good_image = true;
					break;
				}
			}
			if(!$good_image){
				$this->transporter->end_work(__CLASS__, 'i2');
			}
			$mime = array('jpeg','png','gif');
			$good_image = false;
			$imageinfo = getimagesize($_FILES['preview_load']['tmp_name']);
			
			foreach($mime as $mtype){
				$m = explode('/', $imageinfo['mime'])[1];
				if($m === $mtype){
					$this->mime_type = $mtype;
					$good_image = true;
					break;
				}
			}
			if(!$good_image){
				$this->transporter->end_work(__CLASS__, 'i2');
			}
		}
		protected function re_save_img(){
			if($this->mime_type === 'jpeg'){
				$d = imagecreatefromjpeg($_FILES['preview_load']['tmp_name']);
				if($d !== false){
					imagejpeg($d, $_FILES['preview_load']['tmp_name']);
					return true;
				}else{
					return false;
				}
			}elseif($this->mime_type === 'png'){
				$d = imagecreatefrompng($_FILES['preview_load']['tmp_name']);
				if($d !== false){
					imagepng($d, $_FILES['preview_load']['tmp_name']);
					return true;
				}else{
					return false;
				}
			}elseif($this->mime_type === 'gif'){
				$d = imagecreatefromgif($_FILES['preview_load']['tmp_name']);
				if($d !== false){
					imagegif($d, $_FILES['preview_load']['tmp_name']);
					return true;
				}else{
					return false;
				}
			}
		}
		public function delAction(){
			if(!empty($this->params['i'])){
				$iid = abs((int)$this->params['i']);
			}else{
				$this->transporter->end_work(__CLASS__, 'd2');
			}
			$img_data = $this->do_true_action(self::MImages, 'get_img', array($iid));
			if($img_data !== false){
				if(unlink($this->upload_dir . $img_data['iname'])){
					$this->do_true_action(self::MImages, 'del_img', array($iid));
					$this->transporter->end_work(__CLASS__, 'd1');
				}else{
					$this->transporter->end_work(__CLASS__, 'd2');
				}
			}else{
				$this->transporter->end_work(__CLASS__, 'd2');
			}
		}
	}
?>