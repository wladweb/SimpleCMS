<?php
	class PostsModel extends IModel{
		public function get_posts($start, $pagination){
			try{
				$arr = array();
				$sql = "SELECT 
						SQL_CALC_FOUND_ROWS
						p.id, 
						p.title, 
						p.content, 
						p.author, 
						p.subtitle, 
						p.category, 
						p.ctime, 
						p.popular, 
						p.img,
						COALESCE(cnt, 0) as post_comment_count
					FROM posts p
					LEFT JOIN 
						(SELECT post_id, COUNT(cid) as cnt 
						FROM comments
						GROUP BY post_id) as ct 
					ON p.id = ct.post_id
					ORDER BY p.ctime ASC LIMIT ?, ?";
				$arr[] = $sql;
				$arr[] = $start;
				$arr[] = $pagination;
				$stmt = $this->query($arr, PDO::PARAM_INT);
				$result = $stmt->fetchALL(PDO::FETCH_ASSOC);
				$result['all_posts_count'] = $this->select_found_rows();
				return $result;
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_popular_posts(){
			try{
				$arr = array();
				$sql = "SELECT id, title, img FROM posts ORDER BY popular DESC LIMIT 6";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				return $stmt->fetchALL(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_post($post){
			try{
				$arr = array();
				$sql = "SELECT * FROM posts WHERE id = ?";
				$arr[] = $sql;
				$arr[] = $post;
				$stmt = $this->query($arr);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_posts_by_category($cat, $start, $pagination){
			try{
				$arr = array();
				$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM posts WHERE category = ? LIMIT ?, ?";
				$arr[] = $sql;
				$arr[] = $cat;
				$arr[] = $start;
				$arr[] = $pagination;
				$stmt = $this->query($arr, PDO::PARAM_INT);
				$result = $stmt->fetchALL(PDO::FETCH_ASSOC);
				$result['all_posts_count'] = $this->select_found_rows();
				return $result;
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_current_popular($post){
			try{
				$arr = array();
				$sql = "SELECT popular FROM posts WHERE id = ?";
				$arr[] = $sql;
				$arr[] = $post;
				$stmt = $this->query($arr);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function set_current_popular($pop, $id){
			try{
				$arr = array();
				$sql = "UPDATE posts SET popular = ? WHERE id = ? ";
				$arr[] = $sql;
				$arr[] = $pop;
				$arr[] = $id;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function update_post($pid, $title, $subtitle, $category,  $img, $content){
			try{
				$arr = array();
				$sql = "UPDATE posts SET title = ?, subtitle = ?, category = ?,img = ?, content = ? WHERE id = ? ";
				$arr[] = $sql;
				$arr[] = $title;
				$arr[] = $subtitle;
				$arr[] = $category;
				$arr[] = $img;
				$arr[] = $content;
				$arr[] = $pid;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function delete_post($id){
			try{
				$arr = array();
				$sql = "DELETE FROM posts WHERE id = ? ";
				$arr[] = $sql;
				$arr[] = $id;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function add_post($title,$subtitle, $img, $cat, $content, $author, $ctime){
			try{
				$arr = array();
				$sql = "INSERT INTO posts (title,subtitle,img,category,content,author,ctime) VALUES(?,?,?,?,?,?,?)";
				$arr[] = $sql;
				$arr[] = $title;
				$arr[] = $subtitle;
				$arr[] = $img;
				$arr[] = $cat;
				$arr[] = $content;
				$arr[] = $author;
				$arr[] = $ctime;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function move_posts($cat_id){
			try{
				$arr = array();
				$sql = "UPDATE posts SET category = 17 WHERE category = ?";
				$arr[] = $sql;
				$arr[] = $cat_id;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
	}
?>