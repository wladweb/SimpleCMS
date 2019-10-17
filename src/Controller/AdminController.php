<?php

namespace Wladweb\SimpleCMS\Controller;

class AdminController extends IController {

    protected $tpl;
    
    public function indexAction() {
        $this->is_admin();
        $this->tpl = 'main';
        
        $result = $this->data_instance->getAdminBloginfo();
        //var_dump($result);exit;
        $this->data['blog_info'] = $result['bloginfo'];
        $this->data['count_data'] = $result['count_data'];
        
        $this->arr_templates = $this->get_all_templates();
        $this->get_atemplate();
    }

    public function updateAction() {
        $this->is_admin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data['blogname'] = $_POST['blogname'];
            $data['description'] = $_POST['blogdesc'];
            $data['author'] = $_POST['blogauthor'];
            $data['email'] = $_POST['authormail'];
            $data['template'] = $_POST['templ'];
            $data['pagination'] = $_POST['pagination'];
            
            //$this->do_true_action(self::MBloginfo, 'update_blog_info',
                    //array($_POST['blogname'], $_POST['blogdesc'], $_POST['blogauthor'],
               // $_POST['authormail'], $_POST['templ'], $_POST['pagination']));
            
            $this->data_instance->update('Bloginfo', $data);
            
            $this->transporter->end_work(__CLASS__, 'u1');
        } else {
            $this->transporter->end_work(__CLASS__, 'u2');
        }
    }

    private function get_all_templates() {
        
        $arr = scandir('src/View');
        $templates = array();
        $path = $_SERVER['DOCUMENT_ROOT'] . '/src/View/';
        
        foreach ($arr as $item) {
            if (is_file($path . $item . '/style.css')) {
                $templates[] = $item;
            }
        }
        
        return $templates;
    }

}
