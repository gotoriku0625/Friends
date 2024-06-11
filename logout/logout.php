<?php session_start();?>
<?php require 'db-connect.php';?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/roguaut.css">
</head>
<body>
<?php
if(isset($_SESSION['user'])){
 unset($_SESSION['user']);
 echo '<div class="header" style="z-index:100000">';
 echo '<h1 class="h1"><img src="img/kadai.png" style="width:200px;"></h1>';
 echo '<hr>';
 echo '</div>';
 echo '<form action="home1.php" method="post">';
 // フォーム始まり
 echo'<div class="center">';//centerスタート
 echo'<div class="example4"></div>';
 echo'ログアウトしました。<br>';  
 echo'<div class="example4"></div>';
 echo '<input type="submit"  value="ホームへ" class="button">';
 echo'</div>'; //centerエンド
 echo '</form>';//フォーム終了
}else{
echo '<div class="header" style="z-index:100000">';
echo '<h1 class="h1"><img src="img/kadai.png" style="width:200px;"></h1>';
echo '<hr>';
echo '</div>';
echo '<form action="home1.php" method="post">';
// フォーム始まり
echo'<div class="center">';//centerスタート
echo'<div class="example4"></div>';
echo'すでにログアウトしています。';
echo'<div class="example4"></div>';
echo '<input type="submit"  value="ホームへ" class="button">';
echo'</div>'; //centerエンド
echo '</form>';//フォーム終了
}
?>
</body>
</html>