<?php
    $bloginfo = $this->data['bloginfo'];
?>
<div id="footer">
		<p>Автор, <a href="mailto:<?=$bloginfo['email']?>"><?=$bloginfo['author']?></a></p>
	</div>
</div>
<?php $this->footer_data(); ?>
</body>
</html>