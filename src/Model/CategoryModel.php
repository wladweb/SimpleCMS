<?php

namespace Wladweb\SimpleCMS\Model;

use PDO;

class CategoryModel extends IModel {

    public function get_categories($id = false) {
        $arr = array();
        if (!$id) {
            $sql = "SELECT * FROM category";
            $arr[] = $sql;
        } else {
            $sql = "SELECT * FROM category WHERE id = ?";
            $arr[] = $sql;
            $arr[] = $id;
        }
        $stmt = $this->query($arr);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    public function get_categories_edit() {
        $arr = array();
        $sql = "SELECT * FROM category WHERE id != 17";
        $arr[] = $sql;
        $stmt = $this->query($arr);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    public function get_all_categories() {
        $arr = array();
        $sql = "SELECT * FROM category";
        $arr[] = $sql;
        $stmt = $this->query($arr);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    public function add_category($category) {
        $arr = array();
        $sql = "INSERT INTO category (cat_name) VALUES (?)";
        $arr[] = $sql;
        $arr[] = $category;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

    public function update_category($category, $id, $show_it) {
        $arr = array();
        $sql = "UPDATE category SET cat_name = ?, show_it = ? WHERE id = ?";
        $arr[] = $sql;
        $arr[] = $category;
        $arr[] = $show_it;
        $arr[] = $id;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

    public function delete_category($id) {
        $arr = array();
        $sql = "DELETE FROM category WHERE id = ?";
        $arr[] = $sql;
        $arr[] = $id;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

}
