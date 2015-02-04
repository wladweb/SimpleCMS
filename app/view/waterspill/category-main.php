  <div id="mainContent">
	<h1 class="cat"><?=$this->cat_name?></h1>
	<hr><br>
  <?php foreach($this->cat_arr as $this->post) : ?>	
    <div class="blogItem">
      <h2><a href="/single/index/post/<?=$this->post['id']?>"><?=$this->post['title']?></a></h2>
	  
	  <h3 class="subtitle"><?=$this->post['subtitle']?></h3>
	  
      <h3><i><?=$this->post['ctime']?></i></h3>
	  
      <div class="pop-wrapper"><?php $this->get_template('popular_panel.php'); ?></div>
      <p><?=$this->post['content']?></p>
      
      <h3 class="blogMeta">Posted by <b><?=$this->post['author']?></b></h3>
    
    </div><!-- end #blogItem -->
    <?php endforeach; ?>
    
  
  </div><!-- end #mainContent -->