<?php

namespace SimpleCMS\Application\Model;

use PDO;

class UsersModel extends IModel {

    public function addUser($login, $pass, $email, $lv, $utime) {
        $arr = array();
        $sql = "INSERT INTO users (uname, upass, uemail, last_vote, utime) VALUES (?,?,?,?,?)";
        $arr[] = $sql;
        $arr[] = $login;
        $arr[] = $pass;
        $arr[] = $email;
        $arr[] = $lv;
        $arr[] = $utime;
        $stmt = $this->query($arr);
        return $res = $stmt->rowCount();
    }

    public function delete_user($uid) {
        $arr = array();
        $sql = "DELETE FROM users WHERE uid = ?";
        $arr[] = $sql;
        $arr[] = $uid;
        $stmt = $this->query($arr);
        return $res = $stmt->rowCount();
    }

    public function update_user($ukey, $uemail, $upass = false) {
        $arr = array();
        if (!$upass) {
            $sql = "UPDATE users SET uemail = ? WHERE ukey = ?";
            $arr[] = $sql;
            $arr[] = $uemail;
            $arr[] = $ukey;
        } else {
            $sql = "UPDATE users SET uemail = ?, upass = ? WHERE ukey = ?";
            $arr[] = $sql;
            $arr[] = $uemail;
            $arr[] = $upass;
            $arr[] = $ukey;
        }
        $stmt = $this->query($arr);
        return $res = $stmt->rowCount();
    }

    public function get_all_users($start, $pagination) {
        $arr = array();
        $sql = "SELECT SQL_CALC_FOUND_ROWS uid, uname, avatar, role, uemail, utime FROM users ORDER BY role ASC LIMIT ?, ?";
        $arr[] = $sql;
        $arr[] = $start;
        $arr[] = $pagination;
        $stmt = $this->query($arr, PDO::PARAM_INT);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $comments = new CommentsModel;
        foreach ($res as &$item) {
            $item['coment_count'] = $comments->get_comments_count_by_user($item['uid'])['coment_count'];
        }
        $res['all_users_count'] = $this->select_found_rows();
        return $res;
    }

    public function getUser($login, $pass) {
        $arr = array();
        $sql = "SELECT * FROM users WHERE uname = ? AND upass = ? LIMIT 1";
        $arr[] = $sql;
        $arr[] = $login;
        $arr[] = $pass;
        $stmt = $this->query($arr);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function set_key($id, $key) {
        $arr = array();
        $sql = "UPDATE users SET ukey = ? WHERE uid = ?";
        $arr[] = $sql;
        $arr[] = $key;
        $arr[] = $id;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

    public function get_user_as_key($id, $key) {
        $arr = array();
        $sql = "SELECT * FROM users WHERE uid = ? AND ukey=?";
        $arr[] = $sql;
        $arr[] = $id;
        $arr[] = $key;
        $stmt = $this->query($arr);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_last_vote_time($uid) {
        $arr = array();
        $sql = "SELECT last_vote FROM users WHERE uid = ?";
        $arr[] = $sql;
        $arr[] = $uid;
        $stmt = $this->query($arr);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function set_last_vote_time($uid) {
        $arr = array();
        $sql = "UPDATE users SET last_vote = ? WHERE uid = ?";
        $arr[] = $sql;
        $arr[] = time();
        $arr[] = $uid;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

    public function add_admin($login, $pass, $email) {
        $arr = array();
        $sql = "INSERT INTO users (uname, upass, uemail, utime, role) VALUES (?, ?, ?, ?, ?)";
        $arr[] = $sql;
        $arr[] = $login;
        $arr[] = $pass;
        $arr[] = $email;
        $arr[] = time();
        $arr[] = 'admin';
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

}
