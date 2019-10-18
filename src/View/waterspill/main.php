
<div id="mainContent">
    <?php //var_dump($this->posts); ?>
    <?php foreach ($this->data['posts'] as $this->post) : ?>	
        <div class="blogItem">
            <h2><a href="/single/index/post/<?= $this->post['id'] ?>"><?= $this->post['title'] ?></a></h2>

            <h3 class="subtitle"><?= $this->post['subtitle'] ?></h3>

            <h3><i><?= $this->post['ctime'] ?></i></h3>

            <div class="pop-wrapper"><?php $this->show_template('popular_panel.php'); ?></div>
            <p><?= $this->post['content'] ?></p>

            <h3 class="blogMeta">Posted by <b><?= $this->post['author'] ?></b>, <a href="/single/index/post/<?= $this->post['id'] ?>#comments"><?= $this->post['comment_count'] ?> Comments</a></h3>

        </div><!-- end #blogItem -->
    <?php endforeach; ?>
    <div class="pag">
        <?php $this->get_pagination(); ?>
    </div>

</div><!-- end #mainContent -->