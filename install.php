<?php

namespace SimpleCMS;

use SimpleCMS\Application\Model\IModel;
use SimpleCMS\Application\Model\BloginfoModel;
use SimpleCMS\Application\Model\UsersModel;

class SimpleInstall {

    private $model;
    private $bloginfo_model;
    private $users_model;

    public function __construct() {
        $this->model = new IModel;
        $this->bloginfo_model = new BloginfoModel;
        $this->users_model = new UsersModel;
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
    }
    
    protected function add_demo_data(){
        $data = $this->get_post_data();
        $this->bloginfo_model->insert_first_data($data['author'], $data['email'], $data['blog_desc'], $data['blog_name']);
        $this->users_model->add_admin($data['login'], md5(md5($data['pass'])), $data['email']);
    }

}
