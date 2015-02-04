<h3 id="comment-mark">Комментировать:</h3>
<p>
	Ваш комментарий <?=$this->user['uname']?>
</p>
<form method="post" action="/comment/add/postid/<?=$this->post['id']?>/uid/<?=$this->user['uid']?>">
	<textarea class="answer" name="message" cols="30" rows="7"></textarea><br>
	<button type="submit" name="send-message">Комментировать</button>
</form>