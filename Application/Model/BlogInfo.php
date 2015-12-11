<?php

namespace SimpleCMS\Application\Model;

class BlogInfo extends BlogModel{
    
    const TABLE = 'bloginfo';
    
    public function getData(){
        $bloginfo = $this->getRow(self::TABLE, 1);
        return $bloginfo->export();
    }
}

