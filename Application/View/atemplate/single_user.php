<div class="bord">
	<h3>Карточка пользователя</h3>
	<table class="table table-striped table-bordered">
		<tr>
			<td>Роль
			</td>
			<td><?=$this->user['role']?>
			</td>
		</tr>
		<tr>
			<td>Дата регистрации
			</td>
			<td><?=date('d-m-Y', $this->user['utime'])?>
			</td>
		</tr>
		<tr>
			<td>Количество комментариев
			</td>
			<td><?=$this->user['coment_count']?>
			</td>
		</tr>
		<tr>
			<td>Количество оставшихся голосов
			</td>
			<td><?=$this->count_vote?>
			</td>
		</tr>
	</table>
	<form role="form" method="post" action="/users/update">
		<div class="form-group">
			<label for="email" class="control-label">E-mail</label>
			<input type="text" class="form-control" id="email" placeholder="E-mail ..." value="<?=$this->user['uemail']?>" name="email">
		</div>
		<div class="form-group">
			<label for="pass" class="control-label">Новый пароль</label>
			<input type="text" class="form-control" id="pass" placeholder="Пароль ..." name="pass">
		</div>
		<div class="form-group">
			<label for="passagain" class="control-label">Пароль еще раз</label>
			<input type="text" class="form-control" id="passagain" placeholder="Еще раз ..." name="passagain">
		</div>

		<div class="btn-group pull-right">
			<button id="user-update" type ="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> Сохранить</button>
			<a href="/" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Закрыть</a>
		</div>
	</form>
</div>