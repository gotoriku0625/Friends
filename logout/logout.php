<?php session_start();?>
<?php require '../db-connect.php';?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <link rel="stylesheet" href="css/logout.css"> 
</head>
<body>
<div id="center">
<?php
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    echo '<p class="message">ログアウトしました。</p>';
    echo '<a href="../login/login.php" class="btn">ログインへ</a>';
} else {
    echo '<p class="message">すでにログアウトしています。</p>';
    echo '<a href="../login/login.php" class="btn">ログインへ</a>';
}
?>
</div>
</body>
</html>
