<?php

namespace SimpleCMS\Application\Assets;

use SimpleCMS\Application\App;

class Pagination{
    
    private $pagination;
    private $count;
    private $page_count;
    private $current_page;
    
    const START_PARAM = 'pst';
    
    public function __construct($pagination, $count, $current_page) {
        $this->pagination = $pagination;
        $this->count = $count;
        $this->current_page = $current_page/$pagination+1;
        
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
            echo $this->buildLi($i, $li_class, $start_param);
        }
        
        echo '</ul>';
    }
    
    private function buildLi($i, $class, $start_param){
        ++$i;
        $li_element = '';
        
        $li_element .= "<li class='$class'>";
        
        if ($i !== $this->current_page){
            $li_element .= $this->buildA($i, $start_param);
        }else{
            $li_element .= $i;
        }
        
        $li_element .= '</li>';
        
        return $li_element;
    }
    
    private function buildA($anchor, $param){
        $controller  =  strstr(App::getInstance()->getController(), 'Controller', true);
        $action  =  strstr(App::getInstance()->getAction(), 'Action', true);
        
        $href = "/$controller/$action/" . self::START_PARAM . "/$param";

        $a_element = '';
        $a_element .= "<a href='$href'>";
        $a_element .= $anchor;
        $a_element .= '</a>';
        
        return $a_element;
    }
}

