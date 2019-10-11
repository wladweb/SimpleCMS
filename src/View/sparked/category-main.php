
<div class="wrapper row4">
  <main id="container" class="clear"> 
    <!-- container body --> 
    <h1 class="cat"><?=$this->cat_name?></h1>
	<hr><br>
    <ul class="nospace center clear">
	<?php foreach($this->cat_arr as $this->post) : ?>
      <li class="one_third first">
	  <?php $this->show_template('popular_panel.php'); ?>
	  <a href="/single/index/post/<?=$this->post['id']?>"><img class="pad5 borderedbox push30" src="/images/<?=$this->post['img']?>" alt=""></a>
	  <div class="clearfix post-info">
		<span class="float-right"><i><?=$this->post['ctime']?></i></span>
		<span class="float-left"><b><?=$this->post['author']?></b></span>
	</div>
        <h2 class="push10"><?=$this->post['title']?></h2>
		<h3><?=$this->post['subtitle']?></h3>
        <p class="nospace push10"><?=$this->post['content']?></p>
        <p class="nospace"><a href="/single/index/post/<?=$this->post['id']?>">Далее &raquo;</a></p>
      </li>
     <?php endforeach; ?>
    </ul>
    <!-- / container body -->
    <div class="clear"></div>
	<div class="pagination">
		<?php $this->get_pagination(); ?>
	</div>
  </main>
</div>