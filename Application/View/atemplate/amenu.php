
<ul id="admin-menu" class="nav nav-pills nav-stacked">
	<li><a href="/admin">Общие<span class="badge pull-right"><span class="glyphicon glyphicon-home"></span></span></a></li>
	<li><a href="/editposts">Посты<span class="badge pull-right"><?=$this->count_data['count_posts']['data']?></span></a></li>
	<li><a href="/category/editcats">Категории<span class="badge pull-right"><?=$this->count_data['count_category']['data']?></span></a></li>
	<li><a href="/comment/index">Комментарии<span class="badge pull-right"><?=$this->count_data['count_comments']['data']?></span></a></li>
	<li><a href="/users">Пользователи<span class="badge pull-right"><?=$this->count_data['count_users']['data']?></span></a></li>
	<li><a href="/images">Картинки<span class="badge pull-right"><?=$this->count_data['count_images']['data']?></span></a></li>
</ul>