<?php

namespace SimpleCMS\Application\Model;

use RedBeanPHP\R;

class Category extends IModel{
    
    public function getCategoryList($all = false){
        
        $all ? $sql = '' : $sql = "WHERE show_it = 1" ;
        $category_collection = R::findCollection('category', $sql);
        
        $category = array();
        
        while ($cat = $category_collection->next()){
            
                $category[] = $cat->export();
                
        }
       
        return $category;
        
    }
    
    public function testAdd(){
        $cat = R::dispense('category');
        $cat->cat_name = 'Спорт';
        $cat->show_it = 1;
        
        R::store($cat);
    }
}

