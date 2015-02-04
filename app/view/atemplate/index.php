<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Admin area</title>
	<link rel="stylesheet" type="text/css" href="/app/view/atemplate/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/app/view/atemplate/astyle.css">
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<a href="" class="navbar-brand"><?=$this->user['uname']?></a>
			<ul class="nav navbar-nav">
				<li><a href="/">Перейти на сайт</a></li>
			</ul>
		</div>
	</div><!--navbar-->
	<div class="row">
		<div class="container">
			<div class="col-md-3">
				<?php
					$this->get_atemplate_sidebar();
				?>
			</div><!--col-md-3-->
			<div class="col-md-9">
				<?php
					$this->get_atemplate($this->tpl);
				?>
			</div><!--col-md-9-->
		</div>
	</div><!--row-->
<script type="text/javascript" src="/app/view/atemplate/js/jquery.min.js"></script>	
<script type="text/javascript" src="/app/view/atemplate/js/tinymce/tinymce.min.js"></script>	
<script type="text/javascript" src="/app/view/atemplate/bootstrap/js/bootstrap.min.js"></script>	
<script type="text/javascript" src="/app/view/atemplate/js/amain.js"></script>	
</body>
</html>