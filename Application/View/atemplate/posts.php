<a href="/index/add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Новый пост</a>
    <?php foreach ($this->data['posts'] as $post) : ?>
    <div class="row">
        <form method="post" action="/index/update">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <input type="hidden" value="<?= $post['id'] ?>" name="pid">
                    <label for="title">Заголовок поста</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="title" value="<?= $post['title'] ?>">
                    <label for="subtitle">Подзаголовок поста</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="subtitle" value="<?= $post['subtitle'] ?>">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="post_preview">Категория</label>
                                <select class="form-control" name="category">
                                    
                                    <?php foreach ($this->data['cats'] as $category) : ?>
                                        <?php
                                        $selected = '';
                                        $post['category_id'] === $category['id'] ? $selected = 'selected' : $selected = '';
                                        ?>
                                        <option value="<?= $category['id'] ?>" <?= $selected ?>><?= $category['cat_name'] ?></option>
                                    <?php endforeach; ?>  
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <img class="img-responsive img-thumbnail" src="/images/<?php echo $post['img'] ?>">
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="post_preview">Имя файла</label>
                                <input type="text" class="form-control post_preview" id="post_preview" name="img" placeholder="some_file.jpg" value="<?= $post['img'] ?>">
                                <div class="img-anchor"><div class="img-outer"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <textarea name="content" class="form-control post-field" rows="15"><?= $post['content'] ?></textarea>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="btn-group pull-right">
                        <button type ="submit" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span> Редактровать</button>
                        <a href="/index/del/pid/<?= $post['id'] ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Удалить</a>
                    </div>		
                </div>
            </div>
        </form>	
    </div>
<?php endforeach; ?>
<div>
    <?php $this->pagination(); ?>
</div>