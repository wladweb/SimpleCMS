<h3>Комментарии</h3>
<hr>
<div class="comments">
<?php foreach($this->comments as $comment) : ?>
	<div class="comment" id="<?=$comment['anchor']?>">
		<div class="cleft">
			<p class="cauthor"><a class="add-to-answer" href=""><?=$comment['uname']?></a>
			</p>
			<p class="status"><?=$comment['role']?>
			</p>
			<img class="avatar" src="<?php echo '/images/avatars/'.$comment['avatar'] ?>">
			<p class="ccount">Всего: <?=$comment['coment_count']?>
			</p>
		</div>
		<div class="cright">
			<p class="cdate"><?=$comment['ctime']?>
			</p>
			<p class="cbody"><?=$comment['cbody']?>
			</p>
		</div>
	</div><!--comment-->
<?php endforeach; ?>
</div><!--comments-->
