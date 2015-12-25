<?php foreach($this->data['comments'] as $comment) : ?>
<div class="panel panel-default">
	<div class="panel-heading comment-admin-header">
		<img src="<?php $this->get_template_path(); ?>/images/avatars/<?=$comment['user']->avatar?>" class="img-responsive img-circle coment_avatar">
		<span><b><?=$comment['user']->uname?></b></span>
		<span><a href="mailto:<?=$comment['user']->uemail?>"><i><?=$comment['user']->uemail?></i></a></span>
		<span><i><?=$comment['ctime']?></i></span>
		<span>к посту </span>
		<a href="/single/index/post/<?=$comment['post']->id?>"><?=$comment['post']->title?></a>
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
	<?php $this->pagination(); ?>
</div>
