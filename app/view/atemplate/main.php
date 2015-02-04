<form role="form" method="post" action="/admin/update">
  <div class="form-group">
	<label for="blog-name">Название блога</label>
	<input type="text" class="form-control" id="blog-name" placeholder="Название ..." value="<?=$this->blog_info['blogname']?>" name="blogname">
  </div>
  <div class="form-group">
	<label for="description">Краткое описание</label>
	<input type="text" class="form-control" id="description" placeholder="Описание ..." value="<?=$this->blog_info['description']?>" name="blogdesc">
  </div>
  <div class="form-group">
	<label for="author">Автор</label>
	<input type="text" class="form-control" id="author" placeholder="Автор ..." value="<?=$this->blog_info['author']?>" name="blogauthor">
  </div>
  <div class="form-group">
	<label for="author-email">E-mail автора</label>
	<input type="text" class="form-control" id="author-email" placeholder="E-mail ..." value="<?=$this->blog_info['email']?>" name="authormail">
  </div>
  <div class="form-group">
	<label for="template">Шаблон</label>
	<select class="form-control" id="template" name="templ">
	  <?php 
	  foreach($this->arr_templates as $template){
			if($template === $this->template_name){
				echo "<option value='{$template}' selected='selected'>{$template}</option>";
			}else{
				echo "<option value='{$template}'>{$template}</option>";
			}
	  } 
	  ?>
	</select>
	<p class="help-block">Выбор шаблона для Вашего блога</p> 
  </div>
  <div class="form-group">
	<label for="pagi">Пагинация</label>
	<input type="text" class="form-control" id="pagi" placeholder="Pagination" value="<?=$this->blog_info['pagination']?>" name="pagination">
	<p class="help-block">Сколько постов выводить на главной, в категориях и в админке</p>
  </div>
  
  <button type="submit" class="btn btn-success">Сохранить</button>
</form>