<div id="left">
<h1 class="cat"><?=$this->cat_name?></h1>
<hr><br>
<?php foreach($this->cat_arr as $this->post) : ?>
<div class="article">
	<?php $this->get_template('popular_panel.php'); ?>
	<h2><a href="/single/index/post/<?=$this->post['id']?>"><?=$this->post['title']?></a></h2>
	<h3><?=$this->post['subtitle']?></h3>
	<img class="post_preview" src="/images/<?php echo $this->post['img']?>">
	<p><?=$this->post['content']?></p>
</div>	
	<br />
<?php endforeach; ?>
<div class="pag">
	<?php $this->get_pagination(); ?>
</div>
</div>