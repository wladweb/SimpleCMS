<?php

namespace SimpleCMS\Application\Model;

use SimpleCMS\Application\Model\BlogModel;


class Posts extends BlogModel{
    
    const TABLE = 'posts';
    
    public function getPostsList($start, $size){
        $sql = 'ORDER BY ctime DESC';
        $posts_collection = $this->getCollection(self::TABLE, $start, $size, $sql);
        
        while ($post = $posts_collection->next()){
            
                $bufer = $post->export();

                $bufer['author'] = $post->users['uname'];
                $bufer['comment_count'] = count($post->ownCommentsList);
                
                $posts[] = $bufer;
        }
       
        return $posts;
    }
    
   
    
    public function delete($id){
        $this->deleteRow(self::TABLE, $id);
    }
    
    public function add(){
        $data = array(
            'title' => 'Одинадцатый пост',
            'subtitle' => 'Второй пост',
            'content' => 'Второй пост',
            'ctime' => date('Y-m-d H:i:s', time()),
            'popular' => 0,
            'img' => 'hello_world.jpg',
            'category_id' => 1,
            'users_id' => 1
        );
        $this->addRow(self::TABLE, $data);
    }
}

