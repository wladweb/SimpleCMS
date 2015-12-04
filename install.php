<?php

namespace SimpleCMS;

use SimpleCMS\Application\BlogException;
use RedBeanPHP\RedException;
use RedBeanPHP\R;

class SimpleInstall {

    protected $db_data;
    protected $post_data;
    protected $date;

    public function __construct() {

        try {
            $this->get_db_data();
            R::setup("mysql:dbname=" . $this->db_data['dbname'] . ";host=" . $this->db_data['host'], $this->db_data['user'], $this->db_data['pass']);
        } catch (BlogException $blog_e) {
            echo $blog_e->getMessage();
        } catch (RedException $red_e) {
            echo $red_e->getMessage();
        }

        $this->post_data = $this->get_post_data();
        $this->date = date('d-M-Y H:i:s', time());
    }

    protected function clear_string($str) {
        return trim(strip_tags($str));
    }

    protected function get_post_data() {
        $post_data = array();
        $post_data['blog_name'] = $this->clear_string($_POST['blog_name']);
        $post_data['blog_desc'] = $this->clear_string($_POST['blog_desc']);
        $post_data['author'] = $this->clear_string($_POST['author']);
        $post_data['email'] = $this->clear_string($_POST['email']);
        $post_data['login'] = $this->clear_string($_POST['login']);
        $post_data['pass'] = $this->clear_string($_POST['pass']);
        return $post_data;
    }

    public function create_tables() {

        //table category
        $category = R::dispense('category');
        $category->cat_name = "Без категории";
        $category->show_it = 1;

        //table users <-admin
        $auser = R::dispense('users');
        $auser->uname = $this->post_data['login'];
        $auser->avatar = 'site.gif';
        $auser->role = R::enum('role:admin');
        $auser->upass = md5(md5($post_data['pass']));
        $auser->uemail = $this->post_data['email'];
        $auser->ukey = null;
        $auser->lastvote = time();
        $auser->utime = time();

        //table users <-user
        $uuser = R::dispense('users');
        $uuser->uname = 'user';
        $uuser->avatar = 'site.gif';
        $uuser->role = R::enum('role:user');
        $uuser->upass = md5(md5('user'));
        $uuser->uemail = 'user@gmail.com';
        $uuser->ukey = null;
        $uuser->lastvote = time();
        $uuser->utime = time();

        //table posts
        $post = R::dispense('posts');
        $post->title = 'Первый пост';
        $post->content = 'Привет мир!';
        $post->author = $auser;
        $post->subtitle = 'Первая запись в блоге';
        $post->category = $category;
        $post->ctime = $this->date;
        $post->popular = 0;
        $post->img = 'hello_world.jpg';

        //table comments <-admin comment
        $acomment = R::dispense('comments');
        $acomment->cauthor = $auser;
        $acomment->post = $post;
        $acomment->cbody = 'Комметарий админа';
        $acomment->ctime = $this->date;
        $acomment->anchor = 'comm54bb8a7a39c1b';

        //table comments <-user comment
        $ucomment = R::dispense('comments');
        $ucomment->cauthor = $uuser;
        $ucomment->post = $post;
        $ucomment->cbody = 'Первый комметарий пользователя';
        $ucomment->ctime = $this->date;
        $ucomment->anchor = 'comm54bb8a7a39c1a';

        //table images
        $image = R::dispense('images');
        $image->name = 'hello_world.jpg';
        $image->itime = $this->date;

        //table bloginfo
        $bloginfo = R::dispense('bloginfo');
        $bloginfo->author = $this->post_data['author'];
        $bloginfo->email = $this->post_data['email'];
        $bloginfo->blogname = $this->post_data['blog_name'];
        $bloginfo->description = $this->post_data['blog_desc'];
        $bloginfo->template = 'watchis';
        $bloginfo->pagination = 10;

        //save
        R::store($category);
        R::store($auser);
        R::store($uuser);
        R::store($post);
        R::store($acomment);
        R::store($ucomment);
        R::store($image);
        R::store($bloginfo);
    }

    protected function get_db_data() {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/setup.ini';
        if (is_file($path)) {
            $this->db_data = parse_ini_file($path);
        } else {
            throw new BlogException('Проверьте наличие файла setup.ini');
        }
    }

}
