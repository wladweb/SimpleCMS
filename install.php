<?php

namespace SimpleCMS;

use SimpleCMS\Application\BlogException;
use RedBeanPHP\RedException;
use RedBeanPHP\R;

class SimpleInstall {

    protected $post_data;
    protected $date;
    
    /**
     * Setup database connection with RedBeanPHP
     * 
     * @param string $path Path to setup.ini file
     * @return void 
     */
    public function __construct($path) {

        try {
            $db_data = $this->parseIni($path);

            $dsn = "mysql:dbname={$db_data['dbname']};host={$db_data['host']}";
            $user = $db_data['user'];
            $password = $db_data['pass'];
            
            R::setup($dsn, $user, $password);
            
        } catch (BlogException $blog_e) {
            echo $blog_e->getMessage();
        } catch (RedException $red_e) {
            echo $red_e->getMessage();
        }

        $this->post_data = $this->get_post_data();
        
        $dt = new \DateTime;
        $this->date = $dt->format('Y-m-d H:i:s');
    }
    
    /**
     * Clear string, remove tags and spaces
     * 
     * @param string $str Input string
     * @return string Output string
     */
    protected function clear_string($str) {
        return trim(strip_tags($str));
    }
    
    /**
     * Save data from POST
     * 
     * @return array
     */
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
    
    /**
     * Create tables and start data with RedBeanPHP
     * 
     * @return void 
     */
    public function create_tables() {
        
        //table comments <-admin comment
        $acomment = R::dispense('comments');
        $acomment->cbody = 'Комментарий админа';
        $acomment->ctime = $this->date;
        $acomment->anchor = 'comm54bb8a7a39c1b';

        //table comments <-user comment
        $ucomment = R::dispense('comments');
        $ucomment->cbody = 'Первый комметарий пользователя';
        $ucomment->ctime = $this->date;
        $ucomment->anchor = 'comm54bb8a7a39c1a';
        
        //table posts
        $post = R::dispense('posts');
        $post->title = 'Первый пост';
        $post->content = 'Привет мир! Это первый пост в новом блоге!';
        $post->subtitle = 'Первая запись в блоге';
        $post->ctime = $this->date;
        $post->popular = 0;
        $post->img = 'hello_world.jpg';
        $post->ownCommentsList[] = $acomment;
        $post->ownCommentsList[] = $ucomment;
        
        //table category
        $category = R::dispense('category');
        $category->cat_name = "Без категории";
        $category->show_it = 1;
        $category->ownPostsList[] = $post;
        
        //table users <-admin
        $auser = R::dispense('users');
        $auser->uname = $this->post_data['login'];
        $auser->avatar = 'site.gif';
        $auser->role = R::enum('role:admin');
        $auser->upass = md5(md5($post_data['pass']));
        $auser->uemail = $this->post_data['email'];
        $auser->ukey = null;
        $auser->lastvote = $this->date;
        $auser->utime = $this->date;
        $auser->ownCommentsList[] = $acomment;
        $auser->ownPostsList[] = $post;

        //table users <-user
        $uuser = R::dispense('users');
        $uuser->uname = 'user';
        $uuser->avatar = 'site.gif';
        $uuser->role = R::enum('role:user');
        $uuser->upass = md5(md5('user'));
        $uuser->uemail = 'user@gmail.com';
        $uuser->ukey = null;
        $uuser->lastvote = $this->date;
        $uuser->utime = $this->date;
        $uuser->ownCommentsList[] = $ucomment;
        
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
    
    /**
     * Parse ini file
     * 
     * @param string $path Path to setup.ini file
     * @return array Data for database connection
     * @throws BlogException if ini file not found and ini file not valid 
     */
    protected function parseIni($path) {
        
        if (is_file($path)) {
            if (false === $data = parse_ini_file($path)){
                throw new BlogException('Проверьте валидность ini-файла');
            }
        } else {
            throw new BlogException('Проверьте наличие ini-файла');
        }
        
        return $data; 
    }

}
