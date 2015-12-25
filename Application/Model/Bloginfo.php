<?php

namespace SimpleCMS\Application\Model;

class Bloginfo extends BlogModel{
    
    const TABLE = 'bloginfo';
    
    public function getData(){
        $bloginfo = $this->getRow(self::TABLE, 1);
        return $bloginfo->export();
    }
    
    public function update(array $data) {
        $this->updateRow(self::TABLE, 1, $data);
    }
}
