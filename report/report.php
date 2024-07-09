<?php
require '../db-connect.php';

$pdo=new PDO($connect,USER,PASS);
$report='insert into report values (null,?,?,?,?)';
$sql=$pdo->prepare($report);
$sql->execute(array($_SESSION['user']['id'],$_POST['reciver_id'],$_POST['report'],$_POST['re_text']));
$block='insert into block values(null,?,?)';
$sql=$pdo->prepare($block);
$sql->execute([$user_id,$reciver_id]);
echo '<form name="block" action="./talk2.php" method="post">';
    echo '<input type="hidden" name="reciver_id" value="'.$_POST['reciver_id'].'">';
    echo '<SCRIPT language="JavaScript">document.block.submit();</SCRIPT>';
echo '</form>';
?>