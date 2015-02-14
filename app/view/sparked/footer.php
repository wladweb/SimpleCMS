<div class="wrapper row5">
  <footer id="footer" class="clear"> 
    <div class="one_third first">
		<?php $this->show_template('contact_block.php'); ?>
    </div>
    <div class="one_third">
		<?php $this->show_template('last_comments.php'); ?>
     
    </div>
    <div class="one_third">
	<?php $this->show_template('popular.php'); ?>
    </div>
  </footer>
</div>
<div class="wrapper row6">
  <div id="copyright" class="clear"> 
    <p class="fl_left">Copyright &copy; 2014 - All Rights Reserved - <a href="#">Domain Name</a></p>
    <p class="fl_right">Автор, <a title="Awsome blog" href="mailto:<?=$this->blog_info['email']?>"><?=$this->blog_info['author']?></a></p>
  </div>
</div>
<!-- JAVASCRIPTS --> 
<?php $this->footer_data(); ?>
</body>
</html>