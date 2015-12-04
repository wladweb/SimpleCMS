<div>
	<h3>Последние комментарии</h3>
	<ul>
	<?php foreach($this->last_comments as $comment) : ?>	
		<li><a href="/single/index/post/<?=$comment['post_id']?>/#<?=$comment['anchor']?>"><?php echo $comment['cbody']; ?></a></li>
	<?php endforeach; ?>	
	</ul>
</div>