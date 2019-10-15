<?php

namespace Wladweb\SimpleCMS\Model;

use Wladweb\SimpleCMS\Application as App;
use Wladweb\SimpleCMS\Assets\LazyFactory;

class Data{
    
    private $controller;
    private $action;
    private $params;
    private $factory;
    const MODEL_NAMESPACE = 'Wladweb\\SimpleCMS\\Model\\';
    
    public function __construct() {
        //$this->controller = stristr(App::getController(), 'Controller', true);
        //$this->action = stristr(App::getAction(), 'Action', true);
        $this->params = App::getParams();
        $this->factory = new LazyFactory;
    }
    
    public function __call($name, $arguments = array()) { 
        $class = array_shift($arguments);
        
        $class = self::MODEL_NAMESPACE . $class;
        $object = new $class;
        if (empty($arguments)){
            return $object->$name();
        }else{
            return $object->$name($arguments[0]);
        }
        
    }
    
    protected function getCommonData(){
        
        $result['bloginfo'] = $this->factory->getBloginfo()->getData();
        $result['menu'] = $this->factory->getCategory()->getCategories();
        
        //sidebar
        $result['popular_posts'] = $this->factory->getPosts()->getPopularList();
        $result['last_comments'] = $this->factory->getComments()->getLastComments();
        
        return $result;
    }
    
    public function getCategoriesList(){
        return $this->factory->getCategory()->getCategories(true);
    }
    
    public function getIndexData($start, $size){
        
        $result = $this->getCommonData();
        
        $posts_data = $this->factory->getPosts()->getPostsList($start, $size);
        
        $result['posts'] = $posts_data['posts'];
        $result['posts_count'] = $posts_data['posts_count'];
        
        return $result;
    }
    
    public function getCategoryData($id, $start, $size){
        
        $result = $this->getCommonData();
        
        $category_data = $this->factory->getCategory()->getCategoryPosts($id, $start, $size);
        
        $result['category'] = $category_data['category'];
        if (isset($category_data['posts']))
            $result['posts'] = $category_data['posts'];
        $result['posts_count'] = $category_data['posts_count'];
        
        return $result;
    }
    
    public function getPostData($id){
        
        $result = $this->getCommonData();
        
        $post_bean = $this->factory->getPosts()->getPost($id);
        
        $result['comments'] = $post_bean->ownCommentsList;
        $result['post'] = $post_bean->export();
        
        return $result;
    }
    
    public function getUserData($id){
        
        $user_bean = $this->factory->getUsers()->get($id);
        
        $result['comments'] = $user_bean->ownCommentsList;
        $result['user_id'] = $user_bean->id;
        
        return $result;
    }
    
    public function getAdminBloginfo(){
        
        $bloginfo = $this->factory->getBloginfo();
        
        $result['count_data'] = $this->countData();
        $result['bloginfo'] = $bloginfo->getData();
        
        return $result;
    }
    
    public function getComments($start, $size){
        return $this->factory->getComments()->getCommentsList($start, $size);
    }
    
    public function getUsers($start, $size){
        return $this->factory->getUsers()->getUsersList($start, $size);
    }
    
    public function countData(){
        
        $bloginfo = $this->factory->getBloginfo();
        
        $count_data['posts'] = $bloginfo->getCount('posts');
        $count_data['users'] = $bloginfo->getCount('users');
        $count_data['comments'] = $bloginfo->getCount('comments');
        $count_data['category'] = $bloginfo->getCount('category');
        
        return $count_data;
    }
}

