<div id="left">
<?php foreach($this->posts as $this->post) : ?>
<div class="article">
	<?php $this->get_template('popular_panel.php'); ?>
	<h2><a href="/single/index/post/<?=$this->post['id']?>"><?=$this->post['title']?></a></h2>
	<h3><?=$this->post['subtitle']?></h3>
	<div class="clearfix">
		<span class="float-right"><i><?=$this->post['ctime']?></i></span>
		<span class="float-left"><b><?=$this->post['author']?></b></span>
	</div>
	<img class="post_preview" src="/images/<?=$this->post['img']?>" title="" alt="">
	<p><?=$this->post['content']?></p>
</div>	
	<br />
<?php endforeach; ?>
<div class="pag">
	<?php $this->get_pagination(); ?>
</div>	
</div>

		