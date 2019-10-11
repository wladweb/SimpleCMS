<?php foreach($this->data['users'] as $user) : ?>
<div class="row bord">
	<div class="contaner">
		<div class="col-md-2">
			<img src="/images/avatars/<?=$user['avatar']?>" class="img-responsive img-circle">
		</div>
		<div class="col-md-10">
			<div class="panel panel-info">
			<div class="panel-heading">
				<h4 class="panel-title"><?=$user['uname']?></h4>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered table-condensed">
					<tr>
						<td>Роль
						</td>
						<td><?=$user['role']->name?>
						</td>
					</tr>
					<tr>
						<td>Дата регистрации
						</td>
						<td><?=$user['utime']?>
						</td>
					</tr>
					<tr>
						<td>E-mail
						</td>
						<td><?=$user['uemail']?>
						</td>
					</tr>
					<tr>
						<td>Всего комментариев
						</td>
						<td><?=$user['coment_count']?>
						</td>
					</tr>
				</table>
			</div>
			<div class="panel-footer">
				<?php if($user['role'] !== 'admin') : ?>
					<a href="/users/del/uid/<?=$user['uid']?>" class="btn btn-danger btn-sm pull-right"><span class="glyphicon glyphicon-trash"></span> Удалить</a>
				<?php endif; ?>
			</div>
		</div>
		</div>
	</div>
</div>
<?php endforeach; ?>
<div>
	<?php $this->pagination(); ?>
</div>