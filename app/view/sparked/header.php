<!DOCTYPE html>
<html>
<head>
<title><?=$this->blog_info['blogname']?></title>
<meta charset="utf-8">
<link href="<?php echo $this->get_template_path(); ?>style.css" rel="stylesheet" type="text/css" media="all">
<?php $this->header_data(); ?>
</head>
<body id="top">
<div class="wrapper row1">
  <nav id="mainav" class="clear"> 
    <ul class="clear">
      <li class="active"><a href="/">Home</a></li>
      <?php foreach($this->category as $category) : ?>	
			<li><a href="/category/index/cat/<?=$category['id']?>"><?=$category['cat_name']?></a></li>
		<?php endforeach; ?>
    </ul>
  </nav>
</div>
<div class="wrapper row2">
  <header id="header" class="clear"> 
    <div id="logo">
      <h1><a href="/"><?=$this->blog_info['blogname']?></a></h1>
      <p>Тестовый блог MVC</p>
    </div>
  </header>
  <?php $this->get_template('auth_panel.php'); ?>
</div>
 