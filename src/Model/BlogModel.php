<?php

namespace Wladweb\SimpleCMS\Model;

use RedBeanPHP\R;

class BlogModel{
    
    protected function deleteRow($table, $id){
        R::trash($table, $id);
    }

    public function addRow($table, array $data){
        $bean = R::dispense($table);
        
        foreach ($data as $key => $value){
            if (array_key_exists($key, $this->getFields($table))){
                $bean->$key = $value;
            }    
        }
        
        return R::store($bean);
    }
    
    public function updateRow($table, $id, array $data){
        $bean = R::load($table, $id);
        
        foreach ($data as $key => $value){
            if (array_key_exists($key, $this->getFields($table))){
                $bean->$key = $value;
            }
        }
        
        return R::store($bean);
    }
    
    protected function getFields($table){
        return R::inspect($table);
    }
    
    protected function getCollection($table, $start = 0, $size = 10, $sql = ''){
        $collection = R::findCollection($table, $sql . ' LIMIT :start, :size ', array(':start' => $start, ':size' => $size));
        return $collection;
    }
    
    protected function getRow($table, $id){
        return R::load($table, $id);
    }
    
    protected function findRow($table, $sql, array $data){
        return R::find( $table, $sql, $data );
    }
    
    public function getCount($table){
        return R::count($table);
    }
    
    public function getAll($table){
        return R::getAll( 'SELECT * FROM '. $table );
    }
    
    public function save($bean){
        return R::store($bean);
    }
}