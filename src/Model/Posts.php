<?php

namespace Wladweb\SimpleCMS\Model;

use Wladweb\SimpleCMS\Model\BlogModel;


class Posts extends BlogModel{
    
    const TABLE = 'posts';
    
    public function getPostsList($start, $size){
        $sql = 'ORDER BY ctime DESC';
        $post_collection = $this->getCollection(self::TABLE, $start, $size, $sql);
        
        while ($post = $post_collection->next()){
            
                $bufer = $post->export();

                $bufer['author'] = $post->users['uname'];
                $bufer['comment_count'] = count($post->ownCommentsList);
                
                $posts[] = $bufer;
        }
       
        $result['posts'] = $posts;
        $result['posts_count'] = $this->getPostsCount();
        
        return $result;
    }
    
    public function getPopularList(){
        $sql = 'ORDER BY popular DESC';
        $posts_collection = $this->getCollection(self::TABLE, 0, 6, $sql);
        
        while ($post = $posts_collection->next()){
            
                $bufer['id'] = $post->id;
                $bufer['img'] = $post->img;
                $bufer['title'] = $post->title;

                $result[] = $bufer;
        }
        
        return $result;
    }
    
    protected function getPostsCount(){
        return $this->getCount(self::TABLE);
    }
    
    public function delete($id){
        $this->deleteRow(self::TABLE, $id);
    }
    
    public function getPost($id){
        return $this->getRow(self::TABLE, $id);
    }
    
    public function update($data){
        return $this->updateRow(self::TABLE, $data['pid'], $data);
    }
    
    /************************/
    public function add($data){
        $this->addRow(self::TABLE, $data);
    }
}

