<?php

namespace SimpleCMS\Application\Controller;

class CommentController extends IController {

    protected $tpl;
    protected $coment_pagination = 10;

    private function anchor_gen() {
        return 'comm' . uniqid();
    }

    public function addAction() {
        if (isset($_POST['send-message'])) {
            if (!empty($_POST['message'])) {
                $rows = $this->do_true_action(self::MComments, 'addComment',
                        array($_POST['message'], $this->params['postid'], $this->params['uid'],
                    $this->anchor_gen()));
                if (!$rows) {
                    $this->transporter->end_work(__CLASS__, 'ac2',
                            '#comment-mark');
                } else {
                    $this->transporter->end_work(__CLASS__, 'ac1',
                            '#comment-mark');
                }
            } else {
                $this->transporter->end_work(__CLASS__, 'ac3', '#comment-mark');
            }
        } else {
            $this->transporter->end_work(__CLASS__, 'ac2', '#comment-mark');
        }
    }

    public function indexAction() {
        $this->is_admin();
        if (!empty($this->params['pst'])) {
            $this->post_start = $this->params['pst'];
        } else {
            $this->post_start = 0;
        }
        $this->tpl = 'edit_comment';
        $this->count_data = $this->do_true_action(self::MBloginfo,
                'get_menu_count_data');
        $this->comments = $this->do_true_action(self::MComments,
                'get_all_comments',
                array((int) $this->post_start, (int) $this->coment_pagination));
        $this->comment_count = array_pop($this->comments);
        $this->get_atemplate();
    }

    public function editAction() {
        $this->is_admin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['content'])) {
            $content = trim(strip_tags($_POST['content']));
            $cid = abs((int) $_POST['cid']);
            $r = $this->do_true_action(self::MComments, 'edit_comment',
                    array($content, $cid));
            if ($r) {
                $this->transporter->end_work(__CLASS__, 'e1');
            } else {
                $this->transporter->end_work(__CLASS__, 'e2');
            }
        }
    }

    public function delAction() {
        $this->is_admin();
        if (!empty($this->params['cid'])) {
            $cid = (int) $this->params['cid'];
            $r = $this->do_true_action(self::MComments, 'delete_comment',
                    array($cid));
            if ($r) {
                $this->transporter->end_work(__CLASS__, 'd1');
            } else {
                $this->transporter->end_work(__CLASS__, 'd2');
            }
        }
    }

    protected function get_pagination() {
        $arr_page_links = array();
        $page_count = $this->comment_count / $this->coment_pagination;

        $page_count = floor($page_count);
        if ($this->comment_count % $this->coment_pagination !== 0) {
            $page_count++;
        }
        for ($i = 0; $i < $page_count; $i++) {
            $pl = $i * $this->coment_pagination;
            $arr_page_links[] = $pl;
        }
        echo '<h3 class="pag-title">Страницы</h3><ul class="pagination">';
        $anchor = 1;
        $page = $this->post_start / $this->coment_pagination;
        foreach ($arr_page_links as $l) {
            if ($page + 1 === $anchor) {
                echo "<li class='active'>";
            } else {
                echo "<li>";
            }
            echo "<a href='/comment/index/pst/$l'>$anchor</a></li>";
            $anchor++;
        }
        echo '</ul>';
    }

}
