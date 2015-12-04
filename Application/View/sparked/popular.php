<div>
	<h6 class="title">Популярные посты</h6>
      <ul class="nospace clear ftgal">
		<?php foreach($this->popular_posts as $pop) : ?>
			<li class="one_third first"><a href="/single/index/post/<?=$pop['id']?>"><img src="/images/<?=$pop['img']?>" title="<?=$pop['title']?>" /></a></li>
		<?php endforeach; ?>
      </ul>
</div>