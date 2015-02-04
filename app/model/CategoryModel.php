<?php
	class CategoryModel extends IModel{
		public function get_categories($id = false){
			try{
				$arr = array();
				if(!$id){
					$sql = "SELECT * FROM category";
					$arr[] = $sql;
				}else{
					$sql = "SELECT * FROM category WHERE id = ?";
					$arr[] = $sql;
					$arr[] = $id;
				}
				$stmt = $this->query($arr);
				return $stmt->fetchALL(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_categories_edit(){
			try{
				$arr = array();
				$sql = "SELECT * FROM category WHERE id != 17";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				return $stmt->fetchALL(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_all_categories(){
			try{
				$arr = array();
				$sql = "SELECT * FROM category";
				$arr[] = $sql;
				$stmt = $this->query($arr);
				return $stmt->fetchALL(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function add_category($category){
			try{
				$arr = array();
				$sql = "INSERT INTO category (cat_name) VALUES (?)";
				$arr[] = $sql;
				$arr[] = $category;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function update_category($category, $id, $show_it){
			try{
				$arr = array();
				$sql = "UPDATE category SET cat_name = ?, show_it = ? WHERE id = ?";
				$arr[] = $sql;
				$arr[] = $category;
				$arr[] = $show_it;
				$arr[] = $id;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function delete_category($id){
			try{
				$arr = array();
				$sql = "DELETE FROM category WHERE id = ?";
				$arr[] = $sql;
				$arr[] = $id;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
	}
?>