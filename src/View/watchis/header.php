<?php
    $bloginfo = $this->data['bloginfo'];
    $menu = $this->data['menu'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" href="/<?php echo $this->get_template_path(); ?>style.css" type="text/css" />
        <?php $this->header_data(); ?>
        <title><?= $bloginfo['blogname'] ?></title>
    </head>
    <body>
        <div id="content">
            <h1 class="logo"><span class="hr"><?= $bloginfo['blogname'] ?></span> блог!</h1>
            <ul id="top">
                <li><a class="current" href="/">Home</a></li>

                <?php foreach ($menu as $cat) : ?>	
                    <li><a href="/category/index/cat/<?= $cat['id'] ?>"><?= $cat['cat_name'] ?></a></li>
                <?php endforeach; ?>	

            </ul>

            <?php $this->show_template('auth_panel.php'); ?>

            <div id="intro">

                <p><?= $bloginfo['description'] ?></p>
            </div>