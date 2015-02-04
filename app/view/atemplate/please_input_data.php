<?php
	setcookie('bad_close_session', 'true', time()+3600*24*7);
	function clear_string($str){
		return trim(strip_tags($str));
	}
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
	
		$blog_name = clear_string($POST['blog_name']);
		$blog_desc = clear_string($POST['blog_desc']);
		$author = clear_string($POST['author']);
		$email = clear_string($POST['email']);
		$login = clear_string($POST['login']);
		$pass = clear_string($POST['pass']);
		
		$blog_model = new Bloginfo;
		$rowcount = $bloginfo->insert_first_data($author, $email, $blog_desc, $blog_name);
		if($rowcount !== 1) die('Ошибка при добавлении');
		
		$users_model = new UsersModel;
		$rowcount = $users_model->add_admin($login, $pass, $email);
		
		if($rowcount === 1){
			setcookie('bad_close_session', '', time()-3600,'/','/');
			$this->sess_destroy();
			header("Location: /");
		}else{
			die('Ошибка при добавлении');
		}
	}
?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Setup</title>
	<style type="text/css">
		html,body{height:100%;}
		body{
			margin:0;
			padding:0;
			background:url(app/view/atemplate/fon.png);
			color:#555;
		}
		h1{
			font-weight:normal;
			font-size:24px;
			margin:0 0 20px;
			border-bottom:1px solid #000;
			padding:10px;
		}
		.container{
			width:960px;
			height:100%;
			margin:0 auto;
			background:#fff;
			border-left:1px solid #bbb;
			border-right:1px solid #bbb;
			padding:20px;
		}
		fieldset{
			border:1px solid #bbb;
			border-radius:10px;
			margin:10px 0;
			padding:20px;
		}
		label{
			display:block;
			margin:5px;
		}
		[type=text]{
			//display:block;
			width:500px;
			border:1px solid #ccc;
			border-radius:5px;
			height:30px;
			padding:0 10px;
		}
		[type=text]:focus{
			box-shadow:0 0 5px #ccc;
		}
		[type=submit]{
			display:block;
			cursor:pointer;
			border:1px solid #ccc;
			border-radius:5px;
			height:30px;
			padding:0 10px;
			background:#eee;
		}
		[type=submit]:hover{
			background:#ddd;
		}
		.red{
			color:red;
		}
		.error{
			box-shadow:0 0 5px #e43739;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Пожалуйста заполните все поля</h1>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<fieldset>
				<legend>Блог</legend>
				<label for="blog_name">Название блога</label>
				<input type="text" name="blog_name" id="blog_name">
				<span class="red">*</span>
				<label for="blog_desc">Краткое описание блога</label>
				<input type="text" name="blog_desc" id="blog_desc"><span class="red"> *</span>
			</fieldset>
			<fieldset>
				<legend>Автор</legend>
				<label for="author">Имя</label>
				<input type="text" name="author" id="author">
				<span class="red">*</span>
				<label for="email">E-mail</label>
				<input type="text" name="email" id="email">
				<span class="red">*</span>
			</fieldset>
			<fieldset>
				<legend>Учетная запись администратора</legend>
				<label for="login">Логин</label>
				<input type="text" name="login" id="login">
				<span class="red">*</span>
				<label for="pass">Пароль</label>
				<input type="text" name="pass" id="pass">
				<span class="red">*</span>
			</fieldset>
			<button type="submit" id="send-from">
				Отправить
			</button>
		</form>
	</div>
<script src="/lib/jquery.js"></script>	
<script>
	$('#send-from').click(function(){
		var v = [];
		var bad = 0;
		$('[type=text]').each(function(){
			$(this).removeClass('error');
			v.push($(this));
		});
		for(var i=0, l = v.length; i<l; i++){
			var ob = v[i];
			if(ob.val() === ''){
				ob.addClass('error');
				bad++;
			}
		}
		if(bad > 0)
			return false;
	});	
</script>	
</body>
</html>