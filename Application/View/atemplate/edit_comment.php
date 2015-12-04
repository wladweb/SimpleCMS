<?php /*echo '<pre>'; print_r($this->comments);*/ ?>
<?php foreach($this->comments as $comment) : ?>
<div class="panel panel-default">
	<div class="panel-heading comment-admin-header">
		<img src="<?php $this->get_template_path(); ?>/images/avatars/<?=$comment['avatar']?>" class="img-responsive img-circle coment_avatar">
		<span><b><?=$comment['uname']?></b></span>
		<span><a href="mailto:<?=$comment['uemail']?>"><i><?=$comment['uemail']?></i></a></span>
		<span><i><?=$comment['ctime']?></i></span>
		<span>к посту </span>
		<a href="/single/index/post/<?=$comment['post_id']?>"><?=$comment['title']?></a>
	</div>
	<form method="post" action="/comment/edit">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<input type="hidden" name="cid" value="<?=$comment['cid']?>">
			<textarea name="content" class="form-control" rows="4">
<?=$comment['cbody']?>
			</textarea>
			</div>
		</div>
	</div>
	<div class="panel-footer">
		<div class="btn-group pull-right">
			<button type ="submit" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-edit"></span> Редактровать</button>
			<a href="/comment/del/cid/<?=$comment['cid']?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span> Удалить</a>
		</div>		
	</div>
	</form>
</div>
<?php endforeach; ?>
<div>
	<?php $this->get_pagination(); ?>
</div>
