<?php
    $bloginfo = $this->data['bloginfo'];
    $menu = $this->data['menu'];
?>

<!DOCTYPE html>
<html>
<head>
<?php $this->header_data(); ?>
<title><?=$bloginfo['blogname']?></title>
<meta charset="utf-8">
<link href="/<?php echo $this->get_template_path(); ?>style.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<div class="wrapper row1">
  <nav id="mainav" class="clear"> 
    <ul class="clear">
      <li class="active"><a href="/">Home</a></li>
      <?php foreach($menu as $category) : ?>	
			<li><a href="/category/index/cat/<?=$category['id']?>"><?=$category['cat_name']?></a></li>
		<?php endforeach; ?>
    </ul>
  </nav>
</div>
<div class="wrapper row2">
  <header id="header" class="clear"> 
    <div id="logo">
      <h1><a href="/"><?=$bloginfo['blogname']?></a></h1>
      <p>Тестовый блог MVC</p>
    </div>
  </header>
  <?php $this->show_template('auth_panel.php'); ?>
</div>
 