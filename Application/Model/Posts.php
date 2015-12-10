<?php

namespace SimpleCMS\Application\Model;

use RedBeanPHP\R;


class Posts extends IModel{
    
    public function getPostsList($start){
        $sql = "ORDER BY ctime DESC LIMIT :start, :size";
        
        $posts_collection = R::findCollection('posts', $sql,
                array(':start' => (int)$start, ':size' => (int)$this->bloginfo->pagination));
        
        $posts = array();
        
        while ($post = $posts_collection->next()){
            
                $bufer = $post->export();

                $bufer['author'] = $post->users['uname'];
                $bufer['comment_count'] = count($post->ownCommentsList);
                
                $posts[] = $bufer;
        }
       
        return $posts;
    }
    
    
    
    public function testAdd(){
        $post = R::dispense('posts');
        $post->title = 'Одинналцатый пост';
        $post->content = 'Привет мир! Это первый пост в новом блоге!';
        $post->subtitle = 'Подзаголовок записи в блоге';
        $post->ctime = date('Y-m-d H:i:s', time());
        $post->popular = 0;
        $post->img = 'hello_world.jpg';
        
        R::store($post);
    }
}

