<?php

namespace SimpleCMS\Application\Model;

use PDO;

class ImagesModel extends IModel {

    public function get_all_images($start, $pagination) {
        $arr = array();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM images ORDER BY itime DESC LIMIT ?, ?";
        $arr[] = $sql;
        $arr[] = $start;
        $arr[] = $pagination;
        $stmt = $this->query($arr, PDO::PARAM_INT);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result['all_img_count'] = $this->select_found_rows();
        return $result;
    }

    public function add_img($name) {
        $arr = array();
        $sql = "INSERT INTO images (iname) VALUES (?)";
        $arr[] = $sql;
        $arr[] = $name;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

    public function add_avatar($name, $uid) {
        $arr = array();
        $sql = "UPDATE users SET avatar = ? WHERE uid = ?";
        $arr[] = $sql;
        $arr[] = $name;
        $arr[] = $uid;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

    public function get_img($iid) {
        $arr = array();
        $sql = "SELECT * FROM images WHERE iid = ?";
        $arr[] = $sql;
        $arr[] = $iid;
        $stmt = $this->query($arr);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function del_img($iid) {
        $arr = array();
        $sql = "DELETE FROM images WHERE iid = ?";
        $arr[] = $sql;
        $arr[] = $iid;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

}
