<form class="form-inline" method="post" action="/category/add">
	<div class="input-group">
		<input type="text" class="form-control" name="add_cat" placeholder="Категория...">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Добавить</button>
		</span>
	</div>	
</form>
<br>
<table class="table table-hover table-striped table-bordered">
	<tr>
		<th><span class="glyphicon glyphicon-eye-open"></span></th>
		<th colspan="2">Категории</th></tr>
	<?php foreach($this->data['categories'] as $cat) : ?>
		<tr>
			<form method="post" action="/category/update">
				<td class="show_it"><input value="checked" type="checkbox" name="show_it" <?=$cat['show_it']?>>
				</td>
				<td>
					<input type="text" class="form-control" name="category" value="<?=$cat['cat_name']?>">
					<input type="hidden" name="cat_id" value="<?=$cat['id']?>">
				</td>
				<td>
					<div class="btn-group pull-right">
						<button type ="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-edit"></span> Редактровать</button>
						<a href="/category/del/pid/<?=$cat['id']?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Удалить</a>
					</div>
				</td>
			</form>	
		</tr>
	<?php endforeach; ?>
</table>