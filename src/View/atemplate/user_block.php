<img src="/images/avatars/<?=$this->user['avatar']?>" class="img-responsive img-circle">
<div class="row">
	<div class="col-md-12 bord">
		<form enctype="multipart/form-data" method="post" action="/images/avatar">
			<div class="form-group">
				<label for="load-file">Сменить аватар</label>
				<input type="file" id="load-file" name="preview_load" accept="image/*">
				<p class="help-block">Файлы формата jpg, png, gif</p>
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span> Загрузить</button>
			</div>
		</form>
	</div>
</div>
