<?php

namespace SimpleCMS\Application\Controller;

class AdminController extends IController {

    protected $tpl;

    public function indexAction() {
        $this->is_admin();
        $this->tpl = 'main';
        $this->arr_templates = $this->get_all_templates();
        $this->blog_info = $this->do_true_action(self::MBloginfo,
                'get_blog_info');
        $this->count_data = $this->do_true_action(self::MBloginfo,
                'get_menu_count_data');
        $this->get_atemplate();
    }

    public function updateAction() {
        $this->is_admin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->do_true_action(self::MBloginfo, 'update_blog_info',
                    array($_POST['blogname'], $_POST['blogdesc'], $_POST['blogauthor'],
                $_POST['authormail'], $_POST['templ'], $_POST['pagination']));
            $this->transporter->end_work(__CLASS__, 'u1');
        } else {
            $this->transporter->end_work(__CLASS__, 'u2');
        }
    }

    private function get_all_templates() {
        $arr = scandir('app/view');
        $templates = array();
        $path = $_SERVER['DOCUMENT_ROOT'] . '/app/view/';
        foreach ($arr as $item) {
            if (is_file($path . $item . '/style.css')) {
                $templates[] = $item;
            }
        }
        return $templates;
    }

}
