<?php

namespace SimpleCMS\Application\Assets;

use SimpleCMS\Application\App;

class Pagination{
    
    private $start;
    private $pagination;
    private $count;
    private $page_count;
    
    public function __construct($start,  $count, $pagination) {
        $this->start = $start;
        $this->pagination = $pagination;
        $this->count = $count;
        
        $this->calculate();
    }
    
    private function calculate(){
        
        $page_count = floor($this->count / $this->pagination);
        
        if ($this->count % $this->pagination !== 0) {
            $page_count++;
        }
        
        $this->page_count = $page_count;
    }
    
    public function show($ul_class, $li_class, $active_class){
        
        echo "<ul class='$ul_class'>";
        
        for ($i = 0; $i < $this->page_count; $i++) {
            $start_param = $i * $this->pagination;
            echo $this->buildLi($i, $li_class, $start_param);
        }
        
        echo '</ul>';
    }
    
    private function buildLi($i, $class, $start_param){
        ++$i;
        $li_element = '';
        
        $li_element .= "<li class='$class'>";
        $li_element .= $this->buildA($i, $start_param);
        $li_element .= '</li>';
        
        return $li_element;
    }
    
    private function buildA($anchor, $param){
        $controller  =  strstr(App::getInstance()->getController(), 'Controller', true);
        $action  =  strstr(App::getInstance()->getAction(), 'Action', true);
        
        $href = "/$controller/$action/pst/$param";

        $a_element = '';
        $a_element .= "<a href='$href'>";
        $a_element .= $anchor;
        $a_element .= '</a>';
        
        return $a_element;
    }
}

