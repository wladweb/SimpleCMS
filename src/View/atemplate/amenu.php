<?php
    $count_data = $this->data['count_data'];
?>
<ul id="admin-menu" class="nav nav-pills nav-stacked">
	<li><a href="/admin">Общие<span class="badge pull-right"><span class="glyphicon glyphicon-home"></span></span></a></li>
	<li><a href="/index/indexadmin">Посты<span class="badge pull-right"><?=$count_data['posts']?></span></a></li>
	<li><a href="/category/editcats">Категории<span class="badge pull-right"><?=$count_data['category']?></span></a></li>
	<li><a href="/comment/index">Комментарии<span class="badge pull-right"><?=$count_data['comments']?></span></a></li>
	<li><a href="/users">Пользователи<span class="badge pull-right"><?=$count_data['users']?></span></a></li>
</ul>

<?php if ($this instanceof SimpleCMS\Application\Controller\IndexController) : ?>

<hr>
<form enctype="multipart/form-data" method="post" action="/images/upload">
        <div class="form-group">
                <label for="load-file">Загрузить изображение</label>
                <input type="file" id="load-file" name="preview_load" accept="image/*">
                <p class="help-block">Файлы формата jpg, png, gif</p>
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span> Загрузить</button>
        </div>
</form>
<?php endif; ?>
