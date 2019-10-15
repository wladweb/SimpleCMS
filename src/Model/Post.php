<?php namespace Wladweb\SimpleCMS\Model;

use Wladweb\SimpleCMS\Model\IModel;
use Wladweb\SimpleCMS\Exceptions\BlogException;
use RedBeanPHP\R;

class Post extends IModel
{
    private $id; 
    private $title; 
    private $content; 
    private $subtitle; 
    private $ctime; 
    private $img; 
    private $authorId; 
    private $categoryId;
    
    private $bean;
    
    public function __construct($id) {
        parent::__construct();
        $this->bean = R::load('posts', $id);
    }
    
    public function __get($name){
        if (is_null($data = $this->bean->$name)){
            throw new BlogException('Не существующее свойство ' . $name);
        }
        return $data;
    }
    
}

