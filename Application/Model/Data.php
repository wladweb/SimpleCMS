<?php

namespace SimpleCMS\Application\Model;

use SimpleCMS\Application\App;

class Data{
    
    private $controller;
    private $action;
    const MODEL_NAMESPACE = 'SimpleCMS\\Application\\Model\\';
    
    public function __construct() {
        $app = App::getInstance();
        $this->controller = stristr($app->getController(), 'Controller', true);
        $this->action = stristr($app->getAction(), 'Action', true);
    }
    
    public function __call($name, $arguments) {
        $class = array_shift($arguments);
        $params = '';
        if (!empty($arguments)){
            $params = implode(', ', $arguments);
        }

        $class = self::MODEL_NAMESPACE . $class;
        $object = new $class;
        $object->$name($params);
    }
    
    public function getData($start, $size){
        
        if ($this->action !== 'index'){
            return false;
        }
        
        switch ($this->controller){
            case 'index':
                return $this->getIndexData($start, $size);
            case 'index':
                return $this->getIndexData($start, $size);
            case 'index':
                return $this->getIndexData($start, $size);
            case 'index':
                return $this->getIndexData($start, $size);
            case 'index':
                return $this->getIndexData($start, $size);
            case 'index':
                return $this->getIndexData($start, $size);
            default :
                return $this->getIndexData($start, $size);
        }
    }
    
    protected function getIndexData($start, $size){
        $result = array();
        
        $posts = new Posts;
        $result = $posts->getPostsList($start, $size);
        
        return $result;
    }
}

