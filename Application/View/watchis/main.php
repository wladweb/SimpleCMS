<div id="left">

    <?php foreach ($this->data['posts'] as $post) : ?>
    
        <div class="article">
            
            <?php $this->show_template('popular_panel.php'); ?>
            
            <h2><a href="/single/index/post/<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
            <h3><?= $post['subtitle'] ?></h3>
            <div class="clearfix">
                <span class="float-right"><i><?= $post['ctime'] ?></i></span>
                <span class="float-left"><b><?= $post['author'] ?></b></span>
            </div>
            <img class="post_preview" src="/images/<?= $post['img'] ?>" title="" alt="">
            <p><?= $post['content'] ?></p>
        </div>	
        <br />
        
    <?php endforeach; ?>

    <div class="pag">
        <?php $this->get_pagination(); ?>
    </div>	

</div>

