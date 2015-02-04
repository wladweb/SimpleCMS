<?php
	class BloginfoModel extends IModel{
		public function get_blog_info(){
			try{
				$arr = array();
				$sql = "SELECT * FROM blog_info";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function update_blog_info($bname,$bdesc,$bauthor,$amail,$t,$p){
			try{
				$arr = array();
				$sql = "UPDATE blog_info SET blogname = ?, description = ?, author = ?, email = ?, template = ? , pagination = ? WHERE id=1";
				$arr[] = $sql;
				$arr[] = $bname;
				$arr[] = $bdesc;
				$arr[] = $bauthor;
				$arr[] = $amail;
				$arr[] = $t;
				$arr[] = $p;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_template_name(){
			try{
				$arr = array();
				$sql = "SELECT template FROM blog_info LIMIT 1";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_pagination_value(){
			try{
				$arr = array();
				$sql = "SELECT pagination FROM blog_info LIMIT 1";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_menu_count_data(){
			try{
				$arr = array();
				$sql = "SELECT count(*) data FROM posts LIMIT 1";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				$menu_count_data['count_posts'] = $stmt->fetch(PDO::FETCH_ASSOC);
				$arr = array();
				$sql = "SELECT count(*) data FROM category WHERE id !=17 LIMIT 1";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				$menu_count_data['count_category'] = $stmt->fetch(PDO::FETCH_ASSOC);
				$arr = array();
				$sql = "SELECT count(*) data FROM comments LIMIT 1";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				$menu_count_data['count_comments'] = $stmt->fetch(PDO::FETCH_ASSOC);
				$arr = array();
				$sql = "SELECT count(*) data FROM users LIMIT 1";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				$menu_count_data['count_users'] = $stmt->fetch(PDO::FETCH_ASSOC);
				$arr = array();
				$sql = "SELECT count(*) data FROM images LIMIT 1";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				$menu_count_data['count_images'] = $stmt->fetch(PDO::FETCH_ASSOC);
				return $menu_count_data;
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function insert_first_data($author, $email, $desc, $name){
			try{
				$arr = array();
				$sql = "INSERT INTO blog_info (author, email, description, blogname) VALUES (?, ?, ?, ?)";
				$arr[] = $sql;
				$arr[] = $author;
				$arr[] = $email;
				$arr[] = $desc;
				$arr[] = $name;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
	}
?>