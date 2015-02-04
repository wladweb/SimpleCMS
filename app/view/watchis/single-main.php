<div id="left">
<div class="article">
	<?php $this->get_template('popular_panel.php'); ?>
	<h2><?=$this->post['title']?></h2>
	<h3><?=$this->post['subtitle']?></h3>
	<img class="post_preview" src="/images/<?php echo $this->post['img']?>">
	<p><?=$this->post['content']?></p>
</div>	
	<br />
	<?php
		$this->get_comments();
		$this->get_comment_form();
	?>
</div>