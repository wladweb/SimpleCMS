<div>
	<h3>Популярные посты</h3>
	<?php foreach($this->data['popular_posts'] as $pop) : ?>
		<a href="/single/index/post/<?=$pop['id']?>"><img src="/images/<?=$pop['img']?>" title="<?=$pop['title']?>" /></a>
	<?php endforeach; ?>
</div>