<?php

namespace Wladweb\SimpleCMS\Controller;

use Wladweb\SimpleCMS\Assets\Pagination;

class UsersController extends IController {

    protected $tpl;

    public function registerAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $user['uname'] = trim(strip_tags($_POST['login']));
            $user['upass'] = md5(md5(trim(strip_tags($_POST['pass']))));
            $user['uemail'] = trim(strip_tags($_POST['email']));
            $user['utime'] = date('Y-m-d H:i:s', time());
            
            if (!empty($user['uname']) and ! empty($user['upass']) and ! empty($user['uemail'])) {
                
                $result = $this->data_instance->add('Users', $user);
                
                $result ? $r = 'r1': $r = 'r2';
                
                $this->transporter->end_work(__CLASS__, $r);
            }
        }
    }
    
    public function loginAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['login-form'])) {
            
            if (!empty($_POST['login']) and ! empty($_POST['pass'])) {
                
                $user[':uname'] = trim(strip_tags($_POST['login']));
                $user[':upass'] = md5(md5(trim(strip_tags($_POST['pass']))));
                $user['sql'] = 'uname = :uname AND upass = :upass';
                
                $users = $this->data_instance->get('Users', $user);
                
                if (!empty($users)) {
                    $user = array_pop($users);
                    
                    $key = md5(microtime() . rand(1000, 100000));
                    setcookie('uid', $user->id, time() + 3600 * 24 * 30, '/');
                    setcookie('key', $key, time() + 3600 * 24 * 30, '/');
                        
                    $this->data_instance->update('Users', array('uid' => $user->id, 'ukey' => $key));

                    header('Location:/');
                    exit;
                    
                } else {
                    $this->transporter->end_work(__CLASS__, 'l1');
                }
            } else {
                $this->transporter->end_work(__CLASS__, 'l2');
            }
        }
    }

    public function logoutAction() {
        setcookie('uid', '', 1, '/');
        setcookie('key', '', 1, '/');
        $this->user = false;
        header('Location:/');
    }
    
    public function indexAction() {
        $this->is_admin();
        $this->get_post_start_value();
        
        $this->data = $this->data_instance->getUsers($this->post_start, $this->pagination);
        $this->data['count_data'] = $this->data_instance->countData();
        $this->data['pagination'] = $this->data['pagination'] = new Pagination($this->pagination, $this->data['users_count'], $this->params);
        
        //$this->count_data = $this->do_true_action(self::MBloginfo,
                //'get_menu_count_data');
        //$this->users_data = $this->do_true_action(self::MUsers, 'get_all_users',
               // array((int) $this->post_start, (int) $this->pagination));
        //$this->posts_count = array_pop($this->users_data);
        
        $this->tpl = 'users';
        $this->get_atemplate();
    }

    protected function get_pagination() {
        $arr_page_links = parent::get_pagination();
        echo '<h3 class="pag-title">Страницы</h3><ul class="pagination">';
        $anchor = 1;
        $page = $this->post_start / $this->pagination;
        foreach ($arr_page_links as $l) {
            if ($page + 1 === $anchor) {
                echo "<li class='active'>";
            } else {
                echo "<li>";
            }
            echo "<a href='/users/index/pst/$l'>$anchor</a></li>";
            $anchor++;
        }
        echo '</ul>';
    }

    public function editAction() {
        $this->is_user();
        $this->tpl = 'single_user';
        
        //$this->user['coment_count'] = $this->do_true_action(self::MComments,
          //              'get_comments_count_by_user', array($this->user['uid']))['coment_count'];
        
        //echo '<pre>'; var_dump(count($this->user->ownCommentsList)); echo '</pre>'; exit; //DUMPING!!!!
        
        $this->count_vote = $this->get_count_vote();
        $this->get_atemplate();
    }

    protected function get_count_vote() {
        if (isset($_COOKIE['vv']) and $_COOKIE['vv'] < $this->vote_limit) {
            return $this->vote_limit - $_COOKIE['vv'];
        } else {
            
            $dt = new \DateTime($this->user->lastvote);
            $last_vote_time = $dt->getTimeStamp();
            
            if ($last_vote_time + $this->vote_interval < time()) {
                return $this->vote_limit;
            } else {
                $waiting = round(($last_vote_time + $this->vote_interval - time()) /
                        60);
                return 'Вы сможете голосовать через: ' . $waiting . ' минут.';
            }
        }
    }

    public function updateAction() {
        $this->is_user();
        $email = trim(strip_tags($_POST['email']));
        $pass1 = trim(strip_tags($_POST['pass']));
        $pass2 = trim(strip_tags($_POST['passagain']));
        if (
                (empty($email)) or
                ( empty($pass1) and ! empty($pass2)) or
                ( !empty($pass1) and empty($pass2)) or
                ( $pass1 !== $pass2)) {
            $this->transporter->end_work(__CLASS__, 'u2');
        }
        if (empty($pass1) and empty($pass2)) {
            
            //$r = $this->do_true_action(self::MUsers, 'update_user',
                    //array($this->user['ukey'], $email));
            
            $r = $this->data_instance->update('Users', array('uid' => $this->user->id, 'uemail' => $email));
            
            if ($r) {
                $this->transporter->end_work(__CLASS__, 'u1');
            } else {
                $this->transporter->end_work(__CLASS__, 'u3');
            }
        } else {
            $pass = md5(md5($pass1));
            
            //$r = $this->do_true_action(self::MUsers, 'update_user',
                    //array($this->user['ukey'], $email, $pass));
            
            $r = $this->data_instance->update('Users', array('uid' => $this->user->id, 'upass' => $pass, 'uemail' => $email));
            
            if ($r) {
                $this->transporter->end_work(__CLASS__, 'u1');
            } else {
                $this->transporter->end_work(__CLASS__, 'u3');
            }
        }
    }

    public function delAction() {
        
        /*
        $r = $this->do_true_action(self::MUsers, 'delete_user',
                array($this->params['u']));
        $this->do_true_action(self::MComments, 'delete_comments_by_user',
                array($this->params['u']));
         * 
         */
        
        $this->is_admin();
        
        $data= $this->data_instance->getUserData((int)$this->params['uid']);
        
        if ($data['user_id'] === 0){
            $this->transporter->end_work(__CLASS__, 'd2');
        }
        
        foreach ($data['comments'] as $id => $comment){
            $this->data_instance->delete('Comments', $id);
        } 
        
        $this->data_instance->delete('Users', $data['user_id']);
        
        $this->transporter->end_work(__CLASS__, 'd1');
        
    }

}
