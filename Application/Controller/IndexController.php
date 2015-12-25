<?php

namespace SimpleCMS\Application\Controller;

use SimpleCMS\Application\Assets\Pagination;

class IndexController extends IController {

    protected $tpl;
    protected $data;
    const IMG_PATH = '/images/';
    
    public function indexAction() {
        $this->getDataForIndex();

        $this->tpl = 'main.php';
        $this->show_template('index.php');
    }

    public function indexadminAction() {
        $this->is_admin();
        $this->getDataForIndex();
        $this->data['count_data'] = $this->data_instance->countData();
        $this->data['cats'] = $this->data_instance->getCategoriesList();
        
        $this->tpl = 'posts';
        $this->get_atemplate();
    }

    protected function getDataForIndex() {
        $this->get_post_start_value();
        $this->data = $this->data_instance->getIndexData($this->post_start, $this->pagination);
        $this->data['pagination'] = new Pagination($this->pagination, $this->data['posts_count'], $this->params);
    }

    public function _indexAction() {
        $this->get_data();
        $this->get_post_start_value();
        $this->posts = $this->do_true_action(self::MPosts, 'get_posts', array((int) $this->post_start, (int) $this->pagination));
        $this->posts_count = array_pop($this->posts);
        foreach ($this->posts as &$p) {
            $p['content'] = mb_substr($p['content'], 0, $this->preview_character_count, 'utf-8') . '...';
        }

        $this->tpl = 'main.php';
        $this->show_template('index.php');
    }

    public function addAction() {
        
        $this->is_admin();
        $this->tpl = 'add_post';
        
        $this->data['count_data'] = $this->data_instance->countData();
        $this->data['cats'] = $this->data_instance->getCategoriesList();
        
        $this->get_atemplate();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data['title'] = trim(strip_tags($_POST['title']));
            $data['subtitle'] = trim(strip_tags($_POST['subtitle']));
            $data['img'] = trim(strip_tags($_POST['img']));
            $data['category_id'] = trim(strip_tags($_POST['category']));
            $data['content'] = trim(strip_tags($_POST['content']));
            $data['users_id'] = $this->user['id'];
            $data['ctime'] = date('Y-m-d H:i:s', time());
            
            $this->data_instance->add('Posts', $data);
            
            if ($r) {
                $this->transporter->end_work(__CLASS__, 'a1');
            } else {
                $this->transporter->end_work(__CLASS__, 'a2');
            }
        }
    }

    public function delAction() {
        $this->is_admin();
        
        $data= $this->data_instance->getPostData($this->params['pid']);
        
        if ($data['post']['id'] === 0){
            $this->transporter->end_work(__CLASS__, 'd2');
        }
        
        foreach ($data['comments'] as $id => $comment){
            $this->data_instance->delete('Comments', $id);
        } 
        
        $this->data_instance->delete('Posts', $this->params['pid']);
        
        $this->transporter->end_work(__CLASS__, 'd1');
        
    }

    public function updateAction() {
        $this->is_admin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['id'] = abs((int) $_POST['pid']);
            $dat['title'] = trim(strip_tags($_POST['title']));
            $data['subtitle'] = trim(strip_tags($_POST['subtitle']));
            $data['category'] = trim(strip_tags($_POST['category']));
            $data['img'] = trim(strip_tags($_POST['img']));
            $data['content'] = trim(strip_tags($_POST['content'],
                            '<em><a><h1><h1><h2><h3><h4><h5><h6><img><p><strong><table><tr><td><th><sub><sup>'));
            
            $id = $this->data_instance->update('Posts', $data);
            
            if ($id) {
                $this->transporter->end_work(__CLASS__, 'u1');
            } else {
                $this->transporter->end_work(__CLASS__, 'u2');
            }
        } else {
            $this->transporter->end_work(__CLASS__, 'u2');
        }
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
    
    public function imgAction(){
        $arr = scandir($_SERVER['DOCUMENT_ROOT'] . self::IMG_PATH);
        
        if (!is_array($arr)) return false;
        $result = array();
        foreach ($arr as $item){
            if (substr($item, -4, 1) !== '.' or substr($item, 0, 1) === '.'){
                continue;
            }
            
            $result[] = $item;
        }
        
        echo json_encode($result);
    }

}
