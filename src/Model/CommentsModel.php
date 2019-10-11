<?php

namespace Wladweb\SimpleCMS\Model;

use PDO;

class CommentsModel extends IModel {

    public function get_comments($post) {
        $arr = array();
        $sql = "SELECT 
                            c.cid,
                            c.cauthor,
                            c.cbody,
                            c.ctime,
                            c.anchor,
                            u.uid,
                            u.uname,
                            u.avatar,
                            u.role,
                            u.uemail
                    FROM comments c INNER JOIN users u ON cauthor=uid WHERE post_id = ? ORDER BY c.ctime ASC";
        $arr[] = $sql;
        $arr[] = $post;
        $stmt = $this->query($arr);
        $res = $stmt->fetchALL(PDO::FETCH_ASSOC);
        foreach ($res as &$item) {
            $item['coment_count'] = $this->get_comments_count_by_user($item['cauthor'])['coment_count'];
        }
        return $res;
    }

    public function get_comments_count_by_user($uid) {
        $arr = array();
        $sql = "SELECT count(*) coment_count FROM comments WHERE cauthor = ? GROUP BY cauthor";
        $arr[] = $sql;
        $arr[] = $uid;
        $stmt = $this->query($arr);
        return $res = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_all_comments($start, $pagination) {
        $arr = array();
        $sql = "SELECT 
                            SQL_CALC_FOUND_ROWS
                            p.title,
                            c.post_id,
                            c.cid,
                            c.cauthor,
                            c.cbody,
                            c.ctime,
                            c.anchor,
                            u.uid,
                            u.uname,
                            u.avatar,
                            u.role,
                            u.uemail
                    FROM comments c 
                    INNER JOIN users u ON cauthor=uid 
                    INNER JOIN posts p ON c.post_id=p.id 
                    ORDER BY ctime DESC LIMIT ?, ?";
        $arr[] = $sql;
        $arr[] = $start;
        $arr[] = $pagination;
        $stmt = $this->query($arr, PDO::PARAM_INT);
        $res = $stmt->fetchALL(PDO::FETCH_ASSOC);
        $res['all_comments_count'] = $this->select_found_rows();
        return $res;
    }

    public function addComment($comment, $postid, $uid, $anchor) {
        $sql = "INSERT INTO comments (post_id, cauthor, cbody, anchor) VALUES (?,?,?,?)";
        $arr[] = $sql;
        $arr[] = $postid;
        $arr[] = $uid;
        $arr[] = $comment;
        $arr[] = $anchor;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

    public function get_last_comments() {
        $arr = array();
        $sql = "SELECT * FROM comments ORDER BY ctime DESC LIMIT 5";
        $arr[] = $sql;
        $stmt = $this->query($arr);
        return $res = $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    public function edit_comment($content, $cid) {
        $arr = array();
        $sql = "UPDATE comments SET cbody = ? WHERE cid = ?";
        $arr[] = $sql;
        $arr[] = $content;
        $arr[] = $cid;
        $stmt = $this->query($arr);
        return $res = $stmt->rowCount();
    }

    public function delete_comment($cid) {
        $arr = array();
        $sql = "DELETE FROM comments WHERE cid = ?";
        $arr[] = $sql;
        $arr[] = $cid;
        $stmt = $this->query($arr);
        return $res = $stmt->rowCount();
    }

    public function delete_comments_by_post($pid) {
        $arr = array();
        $sql = "DELETE FROM comments WHERE post_id = ? ";
        $arr[] = $sql;
        $arr[] = $pid;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

    public function delete_comments_by_user($uid) {
        $arr = array();
        $sql = "DELETE FROM comments WHERE cauthor = ? ";
        $arr[] = $sql;
        $arr[] = $uid;
        $stmt = $this->query($arr);
        return $stmt->rowCount();
    }

}
