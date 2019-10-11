<div class="row">
    <form method="post" action="/index/add">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label for="title">Заголовок</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок">
                <label for="subtitle">Подзаголовок</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Подзаголовок">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="post_preview">Превью поста</label>
                            <input type="text" class="form-control post_preview" name="img" placeholder="some_file.jpg">
                            <div class="img-anchor"><div class="img-outer"></div></div>
                        </div>
                        <div class="form-group">
                            <label for="post_preview">Категория</label>
                            <select class="form-control" name="category">

                                <?php foreach ($this->data['cats'] as $category) : ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['cat_name'] ?></option>
                                <?php endforeach; ?>  

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <textarea name="content" class="form-control post-field">
                    </textarea>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group pull-right">
                    <button type ="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Сохранить</button>
                </div>		
            </div>
        </div>
    </form>	
</div>
