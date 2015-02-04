<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <?php $this->header_data(); ?>
  <title><?=$this->blog_info['blogname']?></title>
  <link href="<?php echo $this->get_template_path(); ?>style.css" rel="stylesheet" type="text/css" />
  
  <!--[if IE]>
  <style type="text/css"> 
  .twoColFixRtHdr #mainContent { zoom: 1; }
  </style>
  <![endif]-->

</head>

<body>
<div id="container">

  <div id="header">
  
    <h1><?=$this->blog_info['blogname']?></h1>
    
    <h2 class="description"><?=$this->blog_info['description']?></h2>
  
  </div><!-- end #header -->
  
  <div id="topMenu">
  
    <?php $this->get_template('auth_panel.php'); ?>
  
  </div><!-- end #topMenu -->