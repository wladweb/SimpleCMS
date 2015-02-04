<div class="images">
<form enctype="multipart/form-data" method="post" action="/images/upload">
	<div class="form-group bord">
		<label for="load-file">Новая картинка</label>
		<input type="file" id="load-file" name="preview_load" accept="image/*">
		<p class="help-block">Файлы формата jpg, png, gif</p>
		<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span> Загрузить</button>
	</div>
</form>
	<?php foreach($this->images_data as $image_block) : ?>
		<div class="row bord">
			<div class="col-md-6">
				<img class="img-responsive img-rounded" src="/images/<?=$image_block['iname']?>">
			</div>
			<div class="col-md-6">
				<h4>Имя файла</h4>
				<p class="img-url"><i><?=$image_block['iname']?></i></p>
				<h4>Дата загрузки</h4>
				<p class="img-url"><?=$image_block['itime']?></p>
				<h4>URL картинки</h4>
				<p class="img-url">http://<?=$_SERVER['SERVER_NAME']?>/images/<?=$image_block['iname']?></p>
				<hr>
				<a href="/images/del/i/<?=$image_block['iid']?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Удалить</a>
				</form>
			</div>
		</div>
	<?php endforeach; ?>
<div>
	<?php $this->get_pagination(); ?>
</div>	
</div>
