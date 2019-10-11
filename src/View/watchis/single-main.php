<?php
    $post = $this->post;
    $comments = $this->data['comments'];
?>
<div id="left">
<div class="article">
	<?php $this->show_template('popular_panel.php'); ?>
	<h2><?=$post['title']?></h2>
	<h3><?=$post['subtitle']?></h3>
	<img class="post_preview" src="/images/<?php echo $post['img']?>">
	<p><?=$post['content']?></p>
</div>	
	<br />
	<?php
		$this->get_comments();
		$this->get_comment_form();
	?>
</div>