<?php

namespace Wladweb\SimpleCMS\Model;

class Category extends BlogModel{
    
    const TABLE = 'category';
    
     public function getCategories($all = false, $start = 0, $size = 10){
        
        $all ? $sql = '' : $sql = 'WHERE show_it=1';
        
        $category_collection = $this->getCollection(self::TABLE, $start, $size, $sql);
        
        $menu = array();
        while ($cat = $category_collection->next()){
            
                $bufer['id'] = $cat->id;
                $bufer['cat_name'] = $cat->cat_name;
                
                if ((int)$cat->show_it){
                    $bufer['show_it'] = 'checked';
                }else{
                    $bufer['show_it'] = '';
                }
                
                

                $bufer['posts_count'] = count($cat->ownPostsList);
                
                $menu[] = $bufer;
        }
       
        return $menu;
    }
    
    public function getCategoryPosts($id, $start, $length){
        $bean = $this->getRow(self::TABLE, $id);
        
        $result['category'] = array('catname' => $bean->cat_name, 'catid' => $bean->id);
        
        $posts = array();
        
        $needle = array_slice(array_reverse($bean->ownPostsList), $start, $length);
        
        foreach ($needle as $post ){
            $bufer = $post->export();
            $bufer['author'] = $post->users['uname'];
            $bufer['comment_count'] = count($post->ownCommentsList);
            $result['posts'][] = $bufer;
        }
        
        $result['posts_count'] = count($bean->ownPostsList);
        
        return $result;
    }
    
    public function getAllCategory(){
        $result = $this->getAll(self::TABLE);
        
        foreach ($result as &$item){
            if ((int)$item['show_it']){
                $item['show_it'] = 'checked';
            }else{
                $item['show_it'] = '';
            }
        } 
        
        return $result;
    }
    
    public function update($data){
        return $this->updateRow(self::TABLE, $data['cat_id'], $data);
    }
    
    public function delete($id){
        $this->deleteRow(self::TABLE, $id);
    }
    
    public function movePostsToDefault($data){
        $default_cat = 1;
        $bean = $this->getRow(self::TABLE, (int)$data);
        
        foreach ($bean->ownPostsList as $post){
            $post->category_id = $default_cat;
            $this->save($post);
        }
        
    }
    
    public function testAdd(){
        $cat = R::dispense('category');
        $cat->cat_name = 'Спорт';
        $cat->show_it = 1;
        
        R::store($cat);
    }
}

