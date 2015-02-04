<?php
	class ImagesModel extends IModel{
		public function get_all_images($start, $pagination){
			try{
				$arr = array();
				$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM images ORDER BY itime DESC LIMIT ?, ?";
				$arr[] = $sql;
				$arr[] = $start;
				$arr[] = $pagination;
				$stmt = $this->query($arr, PDO::PARAM_INT);
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$result['all_img_count'] = $this->select_found_rows();
				return $result;
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function add_img($name){
			try{
				$arr = array();
				$sql = "INSERT INTO images (iname) VALUES (?)";
				$arr[] = $sql;
				$arr[] = $name;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function add_avatar($name, $uid){
			try{
				$arr = array();
				$sql = "UPDATE users SET avatar = ? WHERE uid = ?";
				$arr[] = $sql;
				$arr[] = $name;
				$arr[] = $uid;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function get_img($iid){
			try{
				$arr = array();
				$sql = "SELECT * FROM images WHERE iid = ?";
				$arr[] = $sql;
				$arr[] = $iid;
				$stmt = $this->query($arr);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
		public function del_img($iid){
			try{
				$arr = array();
				$sql = "DELETE FROM images WHERE iid = ?";
				$arr[] = $sql;
				$arr[] = $iid;
				$stmt = $this->query($arr);
				return $stmt->rowCount();
			}catch(PDOException $e){
				$this->write_log($e->getMessage());
			}
		}
	}
?>