<div id="mainContent">
  	
    <div class="blogItem">
      <h2><?=$this->post['title']?></h2>
	  
	  <h3 class="subtitle"><?=$this->post['subtitle']?></h3>
	  
      <h3><i><?=$this->post['ctime']?></i></h3>
	  
      <div class="pop-wrapper"><?php $this->show_template('popular_panel.php'); ?></div>
	   <img class="post_preview" src="/images/<?php echo $this->post['img']?>">     
      <p><?=$this->post['content']?></p>
    
    </div><!-- end #blogItem -->
    
 	<br />
	<?php
		$this->get_comments();
		$this->get_comment_form();
	?>
  
  </div><!-- end #mainContent -->