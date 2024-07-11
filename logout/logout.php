<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <link rel="stylesheet" href="css/logout.css"> <!-- logout.cssファイルのリンク -->
</head>
<body>
<?php
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    echo '<div id="center">';
    echo '<p class="message">ログアウトしました。</p>';
    echo '<a href="../login/login.html" class="btn">ログインへ</a>';
    echo '</div>';
} else {
    echo '<div id="center">';
    echo '<p class="message">すでにログアウトしています。</p>';
    echo '<a href="../login/login.html" class="btn">ログインへ</a>';
    echo '</div>';
}
?>
</body>
</html>
