<?php

namespace SimpleCMS\Application\Model;

class Category extends BlogModel{
    
    const TABLE = 'category';
    
     public function getMenu($start = 0, $size = 10){
        $sql = 'WHERE show_it=1';
        $sql = '';
        $category_collection = $this->getCollection(self::TABLE, $start, $size, $sql);
        
        $menu = array();
        while ($cat = $category_collection->next()){
            
                $bufer = $cat->export();

                $bufer['posts_count'] = count($cat->ownPostsList);
                
                $menu[] = $bufer;
        }
       
        return $menu;
    }
    
    public function getCategoryPosts($id){
        $bean = $this->getRow(self::TABLE, $id);
        
        $result['caregory'] = array('catname' => $bean->cat_name, 'catid' => $bean->id);
        
        $posts = array();
        
        foreach ($bean->ownPostsList as $post){
            $bufer = $post->export();
            $bufer['author'] = $post->users['uname'];
            $bufer['comment_count'] = count($post->ownCommentsList);
            $result['posts'][] = $bufer;
        }
        
        return $result;
    }
    
    public function testAdd(){
        $cat = R::dispense('category');
        $cat->cat_name = 'Спорт';
        $cat->show_it = 1;
        
        R::store($cat);
    }
}

