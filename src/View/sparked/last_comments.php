<div>
	<h6 class="title">Последние комментарии</h6>
	<ul class="nospace clear">
	<?php foreach($this->data['last_comments'] as $comment) : ?>	
		<li class="clear push10">
			<p class="nospace"><a href="/single/index/post/<?=$comment['post_id']?>/#<?=$comment['anchor']?>"><?php echo $comment['cbody']; ?></a></p>
		</li>
	<?php endforeach; ?>	
	</ul>
</div>