<?php

namespace SimpleCMS\Application\Controller;

class CategoryController extends IController {

    protected $tpl;

    public function indexAction() {
        $this->get_data();
        $this->get_post_start_value();
        if (!empty($this->params['cat'])) {
            $this->cat_name_arr = $this->do_true_action(self::MCategory,
                    'get_categories', array($this->params['cat']));
            $this->cat_arr = $this->do_true_action(self::MPosts,
                    'get_posts_by_category',
                    array($this->params['cat'], (int) $this->post_start, (int) $this->pagination));
            $this->posts_count = array_pop($this->cat_arr);
        } else {
            $this->tpl = '404.php';
            $this->show_template('index.php');
            exit;
        }
        if (!empty($this->cat_name_arr)) {
            $this->cat_name = $this->cat_name_arr[0]['cat_name'];
        }
        if (!empty($this->cat_arr)) {
            foreach ($this->cat_arr as &$p) {
                $p['content'] = mb_substr($p['content'], 0,
                                $this->preview_character_count, 'utf-8') . '...';
            }
            $this->tpl = 'category-main.php';
            $this->show_template('category.php');
        } else {
            $this->tpl = '404.php';
            $this->show_template('index.php');
            exit;
        }
    }

    protected function get_pagination() {
        $arr_page_links = parent::get_pagination();
        if (!empty($arr_page_links)) {
            echo '<h3>Страницы</h3><ul>';
            $anchor = 1;
            foreach ($arr_page_links as $l) {
                $current = '';
                if ($l == $this->post_start) {
                    $current = 'class="current"';
                }
                echo "<li $current><a href='/category/index/cat/{$this->params['cat']}/pst/$l'>$anchor</a></li>";
                $anchor++;
            }
            echo '</ul>';
        }
    }

    public function editcatsAction() {
        $this->is_admin();
        $this->tpl = 'edit_category';
        $this->count_data = $this->do_true_action(self::MBloginfo,
                'get_menu_count_data');
        $this->categories = $this->do_true_action(self::MCategory,
                'get_categories_edit');
        $this->get_atemplate();
    }

    public function addAction() {
        $this->is_admin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = trim(strip_tags($_POST['add_cat']));
            if (empty($category)) {
                $this->transporter->end_work(__CLASS__, 'a3');
            }
            $r = $this->do_true_action(self::MCategory, 'add_category',
                    array($category));
            if ($r) {
                $this->transporter->end_work(__CLASS__, 'a1');
            } else {
                $this->transporter->end_work(__CLASS__, 'a2');
            }
        } else {
            $this->transporter->end_work(__CLASS__, 'a2');
        }
    }

    public function updateAction() {
        $this->is_admin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category = trim(strip_tags($_POST['category']));
            $cat_id = abs((int) ($_POST['cat_id']));
            if (!empty($_POST['show_it']) and $_POST['show_it'] === 'checked') {
                $show_it = trim(strip_tags($_POST['show_it']));
            } else {
                $show_it = '';
            }
            $r = $this->do_true_action(self::MCategory, 'update_category',
                    array($category, $cat_id, $show_it));
            if ($r) {
                $this->transporter->end_work(__CLASS__, 'u1');
            } else {
                $this->transporter->end_work(__CLASS__, 'u3');
            }
        } else {
            $this->transporter->end_work(__CLASS__, 'u2');
        }
    }

    public function delAction() {
        $this->is_admin();
        $pid = $this->params['pid'];
        if (!empty($pid)) {
            $this->do_true_action(self::MPosts, 'move_posts', array($pid));
            $r = $this->do_true_action(self::MCategory, 'delete_category',
                    array($pid));
            if ($r) {
                $this->transporter->end_work(__CLASS__, 'd1');
            } else {
                $this->transporter->end_work(__CLASS__, 'd2');
            }
        } else {
            $this->transporter->end_work(__CLASS__, 'd2');
        }
    }

}
