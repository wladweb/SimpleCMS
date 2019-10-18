<h2>Comments</h2>
    <ol id="comments">
	<?php foreach($this->data['comments'] as $comment) : ?>
    	<li>
			<img class="avatar" src="<?php echo '/images/avatars/'. $comment->users->avatar ?>"><a class="add-to-answer" href=""><b><?=$comment['uname']?></b></a> <span class="ccount">(Всего комментариев: <?=$comment['coment_count']?>)</span> says:
			<p class="commentSep"></p>
			<p><?=$comment['cbody']?></p>
			<p class="cdate"><?=$comment['ctime']?>
			</p>
        </li>
    <?php endforeach; ?>
    </ol>