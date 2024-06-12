<?php session_start();?>
<?php require '../db-connect.php';?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    echo 'ログアウトしました。';
} else {
    echo 'すでにログアウトしています。';
}

?>
</body>
</html>