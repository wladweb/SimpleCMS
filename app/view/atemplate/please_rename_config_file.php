<?php
$_SESSION['first_start'] = true;
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
                margin:0;
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
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Не найден файл конфигурации <b>setup.ini</b></h1>
            <p class="message">
                Разверните базу данных из файла <b>blog_dump.sql</b>.пше 
            </p>
            <p class="message">
                Для создания файла конфигурации отредактируйте и переименуйте файл <b>setup_example.ini</b> в корневой директории сайта.
            </p>
        </div>
    </body>
</html>