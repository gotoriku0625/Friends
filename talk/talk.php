<?php require '../db-connect.php';?>
<?php
if(!isset($_SESSION))session_start();

// トーク内容の取得
$_talk = array();
$rst=query('');

while($col)
?>