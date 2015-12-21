<?php

namespace SimpleCMS\Application\Assets;

use SimpleCMS\Application\Model\Posts;
use SimpleCMS\Application\Model\Category;
use SimpleCMS\Application\Model\Bloginfo;
use SimpleCMS\Application\Model\Users;
use SimpleCMS\Application\Model\Comments;

class LazyFactory {
    
    private $posts;
    private $category;
    private $bloginfo;
    private $users;
    private $comments;

    public function getPosts() {

        if (!$this->posts) {
            $this->posts = new Posts;
        }
        return $this->posts;
    }
    
    public function getCategory() {

        if (!$this->category) {
            $this->category = new Category;
        }
        return $this->category;
    }
    
    public function getBloginfo() {

        if (!$this->bloginfo) {
            $this->bloginfo = new Bloginfo;
        }
        return $this->bloginfo;
    }
    
    public function getUsers() {

        if (!$this->users) {
            $this->users = new Users;
        }
        return $this->users;
    }
    
    public function getComments() {

        if (!$this->comments) {
            $this->comments = new Comments;
        }
        return $this->comments;
    }

}
