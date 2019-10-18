  <div id="sidebar">
  
    <h3>Категории</h3>
    <ul>
    	<li><a href="/">Home</a></li>
        <?php foreach($this->data['menu'] as $category) : ?>	
			<li><a href="/category/index/cat/<?=$category['id']?>"><?=$category['cat_name']?></a></li>
		<?php endforeach; ?>
    </ul>
    
    <h3>Популярные посты</h3>
    <ul>
		<?php foreach($this->data['popular_posts'] as $pop) : ?>
		<li><a href="/single/index/post/<?=$pop['id']?>"><?=$pop['title']?></a></li>
		<?php endforeach; ?>
    </ul>
    
    <h3>Последние комментарии</h3>
    <ul>
    	<?php foreach($this->data['last_comments'] as $comment) : ?>	
		<li><a href="/single/index/post/<?=$comment['post_id']?>/#<?=$comment['anchor']?>"><?php echo $comment['cbody']; ?></a></li>
		<?php endforeach; ?>
    </ul>
  
  </div><!-- end #sidebar -->