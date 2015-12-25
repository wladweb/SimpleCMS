<h3>Комментарии</h3>
<hr>
<div class="comments">
<?php
//echo '<pre>'; var_dump($this->data['comments']); echo '</pre>'; exit; //DUMPING!!!!
foreach($this->data['comments'] as $comment) : ?>
	<div class="comment" id="<?=$comment['anchor']?>">
		<div class="cleft">
			<p class="cauthor"><a class="add-to-answer" href=""><?=$comment->users->uname?></a>
			</p>
			<p class="status"><?=$comment['role']?>
			</p>
			<img class="avatar" src="<?php echo '/images/avatars/' . $comment->users->avatar ?>">
			<p class="ccount">Всего: <?=count($comment->users->ownCommentsList)?>
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
