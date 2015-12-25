<?php
    $category = $this->data['category'];
    //echo '<pre>';var_dump($this->data);exit;
    $posts = $this->data['posts'];
?>
<div id="left">
<h1 class="cat"><?=$category['catname']?></h1>
<hr><br>
<?php foreach($posts as $this->post) : ?>
<div class="article">
	<?php $this->show_template('popular_panel.php'); ?>
	<h2><a href="/single/index/post/<?=$this->post['id']?>"><?=$this->post['title']?></a></h2>
	<h3><?=$this->post['subtitle']?></h3>
	<img class="post_preview" src="/images/<?php echo $this->post['img']?>">
	<p><?=$this->cutText($this->post['content'])?></p>
</div>	
	<br />
<?php endforeach; ?>
<div class="pag">
	<?php $this->pagination(); ?>
</div>
</div>