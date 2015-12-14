<?php

namespace SimpleCMS\Application\Controller;

use SimpleCMS\Application\Assets\Pagination;

class IndexController extends IController {

    protected $tpl;
    protected $data;

    public function indexAction() {
        $this->get_post_start_value();
        $this->data = $this->data_instance->getIndexData($this->post_start, $this->pagination);
        $this->data['pagination'] = new Pagination($this->pagination, $this->data['posts_count'], $this->params);
        
        $this->tpl = 'main.php';
        $this->show_template('index.php');
    }
    
    
    public function _indexAction() {
        $this->get_data();
        $this->get_post_start_value();
        $this->posts = $this->do_true_action(self::MPosts, 'get_posts',
                array((int) $this->post_start, (int) $this->pagination));
        $this->posts_count = array_pop($this->posts);
        foreach ($this->posts as &$p) {
            $p['content'] = mb_substr($p['content'], 0,
                            $this->preview_character_count, 'utf-8') . '...';
        }

        $this->tpl = 'main.php';
        $this->show_template('index.php');
    }
    
    public function addAction(){
        $this->data->add('Posts');
    }
    
    public function deleteAction(){
        $this->data->delete('Posts', $this->params['id']);
    }

    public function badRequest() {
        $this->get_data();
        $this->tpl = 'error.php';
        $this->show_template('index.php');
    }

    public function get_pagination() {
        $arr_page_links = parent::get_pagination();
        if (!empty($arr_page_links)) {
            echo '<h3>Страницы</h3><ul>';
            $anchor = 1;
            foreach ($arr_page_links as $l) {
                $current = '';
                if ($l == $this->post_start) {
                    $current = 'class="current"';
                }
                echo "<li $current><a href='/index/index/pst/$l'>$anchor</a></li>";
                $anchor++;
            }
            echo '</ul>';
        }
    }

}
