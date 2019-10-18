<h2>Комментарии</h2>
<ul>
	<?php foreach($this->data['comments'] as $comment) : ?>
  <li id="<?=$comment['anchor']?>">
	<article>
	  <header>
		<figure class="avatar"><img src="<?php echo '/images/avatars/'. $comment->users->avatar ?>" alt=""></figure>
		<address>
		<span><a class="add-to-answer" href=""><?=$comment['uname']?></a></span>
		<span class="status"><?=$comment['role']?></span>
		<span class="ccount">Всего: <?=$comment['coment_count']?>
		</span>
		</address>
		<time><?=$comment['ctime']?></time>
	  </header>
	  <div class="comcont">
		<p><?=$comment['cbody']?></p>
	  </div>
	</article>
  </li>
  <?php endforeach; ?>
</ul>