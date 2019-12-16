<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#0d47a1">
    <title>Flight bonus program</title>
    <link rel="shortcut icon" href="../../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/login.css">
    <link rel="stylesheet" href="/static/css/icons.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <link rel="stylesheet" href="/static/css/register.css">
    <link rel="stylesheet" href="/static/css/update.css">
</head>
<body>
<div id="application">
    <div class="header">
        <div class="header header_main">
            <i class="icon icon_color_white icon_size_header-fit icon_type_archive"></i>
            <a class="header__title" href="/">COURSACHEIT</a>
        </div>
        <?php
        if (!isset($_SESSION['name'])) {
            echo '<a class="header__exit" href="/auth?login=true">Login</a>';
        } else {
            echo '<a class="header__exit" href="/auth?logout=true">' .$_SESSION['name']. '</a>';
        }
        ?>
    </div>
    <div id="main">
        <?php include 'static/public/views/' . $content_view; ?>
    </div>
</div>
</body>
</html>