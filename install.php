<?php

namespace SimpleCMS;

use SimpleCMS\Application\Model\IModel;
use SimpleCMS\Application\Model\BloginfoModel;
use SimpleCMS\Application\Model\UsersModel;
use RedBeanPHP\R;

class SimpleInstall {
/*
    private $model;
    private $bloginfo_model;
    private $users_model;
*/   
    private $db_data;
    private $post_data;
    private $date;
 

    public function __construct() {
        /*
        $this->model = new IModel;
        $this->bloginfo_model = new BloginfoModel;
        $this->users_model = new UsersModel;
         * 
         */
        R::setup('mysql:dbname=' . $this->db_data['dbname'] . ';host=' . $this->db_data['host'], $db_data['user'], $db_data['pass']);
        $this->post_data = $this->get_post_data();
        $this->date = date('d-M-Y H:i:s', time());
    }
    protected function clear_string($str){
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
    
    public function create_tables(){
        //table category
        $category = R::dispense('category');
        $category->cat_name = "Без категории";
        $category->show_it = R::enum('show_it:checked') ;
        
        //table users <-admin
        $auser = R::dispense('users');
        $auser->uname = $post_data['login'];
        $auser->avatar = 'site.gif';
        $auser->role = R::enum('role:admin');
        $auser->upass = md5(md5($post_data['pass']));
        $auser->uemail = $post_data['email'];
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
        $bloginfo->author = $post_data['author'];
        $bloginfo->email = $post_data['email'];
        $bloginfo->blogname = $post_data['blog_name'];
        $bloginfo->description = $post_data['blog_desc'];
        $bloginfo->template = 'watchis';
        $bloginfo->pagination = 10;
        
        //relations
        $category->ownPostsList[] = $post;
        $user->ownCommentsList[] = $comment;
        $user->ownPostsList[] = $post;
        $post->ownCommentsList[] = $comment;
        
        //save
        R::store($category);
        R::store($auser);
        R::store($uuser);
        R::store($post);
        R::store($acomment);
        R::store($image);
        R::store($bloginfo);
        
        
        /*
        $sql = array(
            "DROP TABLE IF EXISTS `blog_info`",
            
            "CREATE TABLE `blog_info` (
                `author` varchar(255) NOT NULL DEFAULT 'John Dow',
                `email` varchar(255) NOT NULL DEFAULT 'dow@gmail.com',
                `blogname` varchar(255) NOT NULL DEFAULT 'blog',
                `description` varchar(255) NOT NULL DEFAULT 'Это новый блог',
                `template` varchar(255) NOT NULL DEFAULT 'watchis',
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `pagination` int(11) NOT NULL DEFAULT '10',
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8",
            
            "LOCK TABLES `blog_info` WRITE",
            
            "INSERT INTO `blog_info` VALUES ('John Dow','dow@gmail.com','blog','Это новый блог','watchis',31,10)",
            
            "UNLOCK TABLES",
            
            "DROP TABLE IF EXISTS `category`",
            
            "CREATE TABLE `category` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `cat_name` varchar(255) NOT NULL,
                `show_it` enum('checked','') NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8",
            
            "LOCK TABLES `category` WRITE",
            
            "INSERT INTO `category` VALUES (17,'Без категории','')",
            
            "UNLOCK TABLES",
            
            "DROP TABLE IF EXISTS `comments`",
            
            "CREATE TABLE `comments` (
                `cid` int(11) NOT NULL AUTO_INCREMENT,
                `post_id` int(11) NOT NULL,
                `cauthor` int(11) NOT NULL,
                `cbody` mediumtext NOT NULL,
                `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `anchor` varchar(255) NOT NULL,
                PRIMARY KEY (`cid`)
              ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8",
            
            "LOCK TABLES `comments` WRITE",
            
            "INSERT INTO `comments` VALUES (1,1,43,'Первый комментарий','2015-02-06 13:27:19','comm54bb8a7a39c1b')",
            
            "UNLOCK TABLES",
            
            "DROP TABLE IF EXISTS `images`",
            
            "CREATE TABLE `images` (
                `iname` varchar(255) NOT NULL,
                `iid` int(11) NOT NULL AUTO_INCREMENT,
                `itime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`iid`),
                UNIQUE KEY `iname` (`iname`)
              ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8",
            
            "LOCK TABLES `images` WRITE",
            
            "INSERT INTO `images` VALUES ('hello_world.jpg',1,'2015-01-18 10:14:03')",
            
            "UNLOCK TABLES",
            
            "DROP TABLE IF EXISTS `posts`",
            
            "CREATE TABLE `posts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL DEFAULT 'Заголовок',
                `content` mediumtext NOT NULL,
                `author` varchar(255) NOT NULL DEFAULT 'John Dow',
                `subtitle` varchar(255) NOT NULL DEFAULT 'subtitle',
                `category` int(11) NOT NULL DEFAULT '1',
                `ctime` varchar(255) NOT NULL DEFAULT '0',
                `popular` int(11) NOT NULL DEFAULT '0',
                `img` varchar(255) NOT NULL DEFAULT 'site.gif',
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8",
            
            "LOCK TABLES `posts` WRITE",
            
            "INSERT INTO `posts` VALUES (1,'Первый пост','Привет мир!','admin','Первая запись в блоге',17,'18-01-15 14:26:16',0,'hello_world.jpg')",
            
            "UNLOCK TABLES",
            
            "DROP TABLE IF EXISTS `users`",
            
            "CREATE TABLE `users` (
                `uid` int(11) NOT NULL AUTO_INCREMENT,
                `uname` varchar(255) NOT NULL,
                `avatar` varchar(255) NOT NULL DEFAULT 'site.gif',
                `role` enum('admin','user') NOT NULL DEFAULT 'user',
                `upass` varchar(32) NOT NULL,
                `uemail` varchar(255) NOT NULL,
                `ukey` varchar(32) DEFAULT NULL,
                `last_vote` varchar(255) DEFAULT '000000000000000',
                `utime` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`uid`)
              ) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8",
            
            "LOCK TABLES `users` WRITE",
            
            "INSERT INTO `users` VALUES (43,'FirstUser','site.gif','user','d9b1d7db4cd6e70935368a1efb10e377','first_user@gmail.com',NULL,'1423142795','1423229195')",
            
            "UNLOCK TABLES"
        );
        
        foreach($sql as $request){
            $request = array($request);
            try{
                $this->model->query($request);
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
        $this->add_demo_data();
         * 
         */
    }
    
    protected function get_db_data() {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/setup.ini';
        if (is_file($path)) {
            $this->db_data = parse_ini_file($path);
        } else {
            throw new Exception('Проверьте наличие файла setup.ini');
        }
    }
    
    protected function add_demo_data(){
        $data = $this->get_post_data();
        $this->bloginfo_model->insert_first_data($data['author'], $data['email'], $data['blog_desc'], $data['blog_name']);
        $this->users_model->add_admin($data['login'], md5(md5($data['pass'])), $data['email']);
    }

}
