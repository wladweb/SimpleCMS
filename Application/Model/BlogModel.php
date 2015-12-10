<?php

namespace SimpleCMS\Application\Model;

use RedBeanPHP\R;

class BlogModel{
    
    public function __construct($path) {
        $db_data = $this->parseIni($path);
        
        $dsn = "mysql:host={$db_data['host']};dbname={$db_data['dbname']}";
        $user = $db_data['user'];
        $password = $db_data['pass'];
        
        R::setup($dsn, $user, $password);
    }
    
    protected function parseIni($path) {
        
        if (is_file($path)) {
            if (false === $data = parse_ini_file($path)){
                throw new BlogException('Проверьте валидность ini-файла');
            }
        } else {
            throw new BlogException('Проверьте наличие ini-файла');
        }
        
        return $data; 
    }
    
    public function test(){
        var_dump(R::load('posts',1));exit;
    }
}