<?php

namespace SimpleCMS\Application\Assets;

use SimpleCMS\Application\App;

class Pagination{
    
    private $pagination;
    private $count;
    private $page_count;
    private $current_page;
    private $params;
    
    const START_PARAM = 'pst';
    
    public function __construct($pagination, $count, $params) {
        $this->pagination = $pagination;
        $this->count = $count;
        $this->params = $params;
        $this->current_page = $this->getCurrentPage();
        
        $this->calculate();
    }
    
    private function calculate(){
        
        $page_count = floor($this->count / $this->pagination);
        
        if ($this->count % $this->pagination !== 0) {
            $page_count++;
        }
        
        $this->page_count = (int)$page_count;
                
    }
    
    public function show($ul_class, $li_class, $active_class){
        
        echo "<ul class='$ul_class'>";
        
        for ($i = 0; $i < $this->page_count; $i++) {
            $start_param = $i * $this->pagination;
            echo $this->buildLi($i, $li_class, $active_class, $start_param);
        }
        
        echo '</ul>';
    }
    
    private function buildLi($i, $class, $active_class, $start_param){
        ++$i;
        $li_element = '';
        
        if ($i !== $this->current_page){
            $li_element .= "<li class='$class'>";
        }else{
            $li_element .= "<li class='$class $active_class'>";
        }
        
        $li_element .= $this->buildA($i, $start_param);
        
        $li_element .= '</li>';
        
        return $li_element;
    }
    
    private function buildA($anchor, $param){
        $controller  =  lcfirst(strstr(App::getInstance()->getController(), 'Controller', true));
        $action  =  strstr(App::getInstance()->getAction(), 'Action', true);
        
        $param_string = '';
        
        $this->params[self::START_PARAM] = $param;
        
        foreach ($this->params as $part1 => $part2){
            $param_string .= $part1 . '/' . $part2 . '/';
        }
        
        
        $href = "/$controller/$action/" . $param_string;

        $a_element = '';
        $a_element .= "<a href='$href'>";
        $a_element .= $anchor;
        $a_element .= '</a>';
        
        return $a_element;
    }
    
    protected function getCurrentPage(){
        //
        isset($this->params[Pagination::START_PARAM])? $current_page = $this->params[Pagination::START_PARAM] : $current_page = 1;
        
        $pst = 0;
        
        if (isset($this->params[Pagination::START_PARAM])){
            $pst = $this->params[Pagination::START_PARAM];
        }
         
        $current_page = $pst/$this->pagination+1;
        
        return $current_page;
    }
}

