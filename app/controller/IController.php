<?php

namespace SimpleCMS\Application\Controller;

use SimpleCMS\Application\App;
use SimpleCMS\Application\Model\ModelFactory;

abstract class IController {

    const MPosts = 0;
    const MBloginfo = 1;
    const MComments = 2;
    const MCategory = 3;
    const MUsers = 4;
    const MImages = 5;

    protected $params;
    protected $template_name;
    protected $user;
    protected $pagination;
    protected $vote;
    protected $model_factory;
    protected $vote_interval;
    protected $vote_limit = 10;
    protected $preview_character_count = 300;
    protected $admin_template = 'atemplate';
    protected $transporter;
    protected $post;
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
        $this->params = App::getInstance()->getParams();
        $this->transporter = new Transporter;
        $this->model_factory = new ModelFactory;
        $this->vote_interval = 3600 * 2;
        $this->set_template_name();
        $this->set_pagination();
        $this->checkUser();
        $this->chek_message();
    }

    public function do_true_action($code, $action, $pars = array()) {
        $model = $this->model_factory->get_model($code);
        $reflectionModel = new \ReflectionObject($model);
        if ($reflectionModel->hasMethod($action)) {
            $method = $reflectionModel->getMethod($action);
            return $method->invokeArgs($model, $pars);
        }
    }

    protected function set_template_name() {
        $this->template_name = $this->do_true_action(self::MBloginfo,
                        'get_template_name')['template'];
    }

    protected function set_pagination() {
        $this->pagination = $this->do_true_action(self::MBloginfo,
                        'get_pagination_value')['pagination'];
    }

    protected function chek_message() {
        $this->transporter->get_message();
    }

    protected function checkUser() {
        if (!empty($_COOKIE['uid']) and ! empty($_COOKIE['key'])) {
            $user = $this->do_true_action(self::MUsers, 'get_user_as_key',
                    array($_COOKIE['uid'], $_COOKIE['key']));
            if ($user) {
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
                $this->do_true_action(self::MUsers, 'set_last_vote_time',
                        array($this->user['uid']));
                setcookie('vv', '', time() - 3600, '/');
            } else {
                $this->vote = true;
            }
        } else {
            $dt = $this->do_true_action(self::MUsers, 'get_last_vote_time',
                            array($this->user['uid']))['last_vote'];
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
        } elseif ($this->user['role'] !== 'admin') {
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

    protected function get_data() {
        $this->blog_info = $this->do_true_action(self::MBloginfo,
                'get_blog_info');
        $this->category = $this->do_true_action(self::MCategory,
                'get_categories_edit');
        $this->popular_posts = $this->do_true_action(self::MPosts,
                'get_popular_posts');
        $this->last_comments = $this->do_true_action(self::MComments,
                'get_last_comments');
        foreach ($this->last_comments as &$lc) {
            $lc['cbody'] = mb_substr($lc['cbody'], 0, 30, 'utf-8') . '...';
        }
    }

    protected function get_login_form() {
        $this->get_template('login_form.php');
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

    public function get_template($tpl) {
        include $this->get_template_name() . '/' . $tpl;
    }

    public function get_template_path() {
        return '/app/view/' . $this->get_template_name() . '/';
    }

    protected function get_atemplate($tpl = false) {
        if (!$tpl) {
            include $this->admin_template . '/index.php';
        } else {
            include $this->admin_template . "/$tpl.php";
        }
    }

    protected function get_pagination($cnt) {
        $arr_links = array();
        $page_count = $cnt / $this->pagination;
        $page_count = floor($page_count);
        if ($cnt % $this->pagination !== 0) {
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
            require_once 'atemplate/user_block.php';
        } else {
            require_once 'atemplate/amenu.php';
        }
    }

    public function footer_data() {
        foreach ($this->sys_scripts as $n => $s) {
            $this->add_script($n, $s);
            $path = '/lib/' . $s;
            echo "<script type='text/javascript' src=$path></script>\n\r";
        }
        include_once $this->get_template_name() . '/inc.php';
        foreach ($this->scripts as $name => $script) {
            $path = '/app/view/' . $this->get_template_name() . '/js/' . $script;
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

}
