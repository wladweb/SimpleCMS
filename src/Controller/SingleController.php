<?php

namespace Wladweb\SimpleCMS\Controller;

class SingleController extends IController {

    protected $post;
    protected $tpl;

    public function indexAction() {
        
        if (!empty($this->params['post'])) {
            $this->data = $this->data_instance->getPostData($this->params['post']);
            
            $this->tpl = 'single-main.php';
            if ($this->data['post']['id'] === 0){
                $this->tpl = '404.php';
            }
            
            $this->post = $this->data['post'];
        }else{
            header('Location: /');exit;
        }
        
        $this->show_template('single.php');
    }

    public function get_comments() {
        if (!empty($this->data['comments'])) {
            include $this->get_template_path() . '/comments.php';
        } else {
            echo '<p id="comments" class="comment-mark">Нет комментариев</p>';
        }
    }

    public function get_comment_form() {
        if ($this->user) {
            include $this->get_template_path() . '/comment_form.php';
        } else {
            echo '<p>Для добавления комментария вы должны <a href="">войти</a></p>';
        }
    }

    protected function i_can_vote() {
        if (!$this->vote) {
            $this->transporter->end_work(__CLASS__, 'p3');
        }
    }

    public function popularAction() {
        $this->is_user();
        $this->i_can_vote();
        if (empty($this->params['pid'])) {
            $this->transporter->end_work(__CLASS__, 'p2');
        } elseif (empty($this->params['pop'])) {
            $this->transporter->end_work(__CLASS__, 'p2');
        } else {
            if ($this->params['pop'] !== 'p' and $this->params['pop'] !== 'm') {
                $this->transporter->end_work(__CLASS__, 'p2');
            } else {

                //$current_popular = $this->do_true_action(self::MPosts,
                                //'get_current_popular',
                               // array($this->params['pid']))['popular'];
                $post = $this->data_instance->getPost('Posts', $this->params['pid']);
                
                $current_popular = $post->popular;
                //var_dump($current_popular);exit;
                
                if ($this->params['pop'] == 'p') {
                    $current_popular++;
                } elseif ($this->params['pop'] == 'm') {
                    $current_popular--;
                }

                //$this->do_true_action(self::MPosts, 'set_current_popular',
                   //     array($current_popular, $this->params['pid']));
                
                $this->data_instance->update('Posts', array('pid' => $this->params['pid'], 'popular' => $current_popular));
                
                if (isset($_COOKIE['vv'])) {
                    $cc = $_COOKIE['vv'];
                    $cc++;
                    setcookie('vv', $cc, time() + $this->vote_interval, '/');
                } else {
                    setcookie('vv', 1, time() + $this->vote_interval, '/');
                }
                $this->transporter->end_work(__CLASS__, 'p1');
            }
        }
    }

}
