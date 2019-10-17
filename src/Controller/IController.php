<?php

namespace Wladweb\SimpleCMS\Controller;

use Wladweb\SimpleCMS\Application as App;
use Wladweb\SimpleCMS\Model\Data;
use Wladweb\SimpleCMS\Assets\Transporter;

abstract class IController {
/*
    const MPosts = 0;
    const MBloginfo = 1;
    const MComments = 2;
    const MCategory = 3;
    const MUsers = 4;
    const MImages = 5;
*/
    protected $model;
    protected $params;
    protected $ini_file = 'setup.ini';
    protected $data_instance;
    
    protected $template_name = 'watchis';
    protected $user;
    protected $pagination = 3;
    protected $vote;
    protected $model_factory;
    protected $vote_interval = 7200; //2 часа
    protected $vote_limit = 10;
    protected $preview_character_count = 300;
    protected $admin_template = 'atemplate';
    protected $transporter;
    protected $post;
    protected $posts_count;
    protected $post_start = 0;
    protected $scripts = array();
    protected $styles = array();
    
    protected $sys_scripts = array(
        'jquery' => 'jquery.js',
        'sys_script' => 'sys_script.js'
    );
    protected $sys_styles = array(
        'sys_style' => 'sys_style.css'
    );

    public function __construct() {
        $this->params = App::getParams();
        $this->data_instance = new Data;
        $this->transporter = new Transporter;
        $this->set_template_name();
        $this->check_message();
        $this->check_user();
    }
    
    public function pagination($ul_class = 'pagination', $li_class = 'pagination-item', $active_class = 'active'){
        $p = $this->data['pagination'];
        $p->show($ul_class, $li_class, $active_class);
    }
 
    protected function set_template_name() 
    {
        $bloginfo = $this->data_instance->getAdminBloginfo();
        $this->template_name = $bloginfo['bloginfo']['template'];
    }

    protected function check_message() {
        $this->transporter->get_message();
    }

    protected function check_user() {
        if (!empty($_COOKIE['uid']) and ! empty($_COOKIE['key'])) {
            
            $user = $this->data_instance->get('Users', array('sql' => 'id = :id AND ukey = :ukey', ':id' => $_COOKIE['uid'], ':ukey' => $_COOKIE['key']));
            
            if ($user) {
                $user = array_pop($user);
                $this->setUser($user);
                $this->chek_vote();
            } else {
                
                $this->setUser(false);
            }
        }
    }

    protected function chek_vote() {
        
        if (isset($_COOKIE['vv'])) {
            
            if ($_COOKIE['vv'] >= $this->vote_limit) {
                
                $this->vote = false;
                
                $this->data_instance->update('Users', array('id' => $this->user->id, 'lastvote' => date('Y-m-d H:i:s', time())));
                
                setcookie('vv', '', time() - 3600, '/');
            } else {
                
                $this->vote = true;
            }
        } else {
            
            $date_time = new \DateTime($this->user->lastvote);
            $dt = $date_time->getTimestamp();
            
            if ($dt + $this->vote_interval < time()) {
                $this->vote = true;
            } else {
                $this->vote = false;
            }
        }
    }

    protected function is_admin() {
        if (!$this->user) {
            header('Location:/');
            exit;
        } elseif ($this->user->role->name !== 'ADMIN') {
            header('Location:/');
            exit;
        }
    }

    protected function is_user() {
        if (!$this->user) {
            header('Location:/');
            exit;
        }
    }

    protected function get_login_form() {
        $this->show_template('login_form.php');
    }

    protected function get_popular_panel() {
        include $this->get_template_name() . '/popular_panel.php';
    }

    protected function setUser($user) {
        $this->user = $user;
    }

    public function get_template_name() {
        return $this->template_name;
    }

    public function show_template($tpl) {
        include $this->get_template_path() . $tpl;
    }

    public function get_template_path() {
        return 'src/View/' . $this->get_template_name() . '/';
    }
    
    public function get_atemplate_path() {
        return 'src/View/' . $this->admin_template . '/';
    }

    protected function get_atemplate($tpl = false) {
        if (!$tpl) {
            include $this->get_atemplate_path() . '/index.php';
        } else {
            include $this->get_atemplate_path() . "/$tpl.php";
        }
    }

    protected function get_pagination() {
        $arr_links = array();
        $page_count = $this->posts_count / $this->pagination;
        $page_count = floor($page_count);
        if ($this->posts_count % $this->pagination !== 0) {
            $page_count++;
        }
        for ($i = 0; $i < $page_count; $i++) {
            $pl = $i * $this->pagination;
            $arr_links[] = $pl;
        }
        return $arr_links;
    }

    protected function get_atemplate_sidebar() {
        
        $uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        
        if (empty($uri[1])) $uri[1] = 'index';
        
        $uri_need = '/' . $uri[0] . '/' . $uri[1];
        
        if ($uri_need === '/users/edit') {
            require_once $this->get_atemplate_path() . 'user_block.php';
        } else {
            require_once $this->get_atemplate_path() . 'amenu.php';
        }
    }

    public function footer_data() {
        
        foreach ($this->sys_scripts as $n => $s) {
            $this->add_script($n, $s);
            $path = '/lib/' . $s;
            echo "<script type='text/javascript' src=$path></script>\n\r";
        }
        
        include_once $this->get_template_path() . 'inc.php';
        
        foreach ($this->scripts as $name => $script) {
            $path = '/Application/View/' . $this->get_template_name() . '/js/' . $script;
            if (is_file($_SERVER['DOCUMENT_ROOT'] . $path)) {
                echo "<script type='text/javascript' src=$path></script>\n\r";
            }
        }
    }

    public function header_data() {
        foreach ($this->sys_styles as $n => $s) {
            $path = "/lib/$s";
            echo "<link rel='stylesheet' type='text/css' href='$path'>\r\n";
        }
    }

    protected function add_script($name, $file) {
        if (!array_key_exists($name, $this->scripts)) {
            $this->scripts[$name] = $file;
        } else {
            unset($this->scripts[$name]);
        }
    }
    
    protected function get_post_start_value(){
        if (!empty($this->params['pst'])) {
            $this->post_start = (int)$this->params['pst'];
        } 
    }
    
    protected function cutText($text) {
        return mb_substr($text, 0, $this->preview_character_count, 'utf-8') . '...';
    }
    
    public function menuCountItem(){
        return $this->data_instance->getCountItem();
    }
}
