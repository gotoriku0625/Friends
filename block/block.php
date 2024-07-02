<?php
require '../db-connect.php';

$pdo=new PDO($connect,USER,PASS);
$block='insert into block values (null,?,?)';
$sql=$pdo->prepare($block);
$sql->execute(array($_SESSION['user']['id'],$_POST['reciver_id']));
?>