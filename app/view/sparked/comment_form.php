<h2 id="comment-mark">Комментировать:</h2>
<p>
	Ваш комментарий <?=$this->user['uname']?>
</p>
<form method="post" action="/comment/add/postid/<?=$this->post['id']?>/uid/<?=$this->user['uid']?>">
	<textarea class="answer" name="message" cols="30" rows="7"></textarea><br>
	<input type="submit" name="send-message" value="Комментировать">
</form>