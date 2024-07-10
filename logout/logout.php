<?php session_start();?>
<?php require '../db-connect.php';?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/logout.css">
</head>
<body>
<?php
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    echo '<div class="message">ログアウトしました。</div>';
    echo '<a href="../login/login.html" class="btn">ログインへ</a>';
} else {
    echo '<div class="message">すでにログアウトしています。</div>';
    echo '<a href="../login/login.html" class="btn">ログインへ</a>';
}
?>
</body>
</html>
