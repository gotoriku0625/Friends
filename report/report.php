<?php
require '../db-connect.php';

$pdo=new PDO($connect,USER,PASS);
$block='insert into report values (null,?,?,?,?)';
$sql=$pdo->prepare($block);
$sql->execute(array($_SESSION['user']['id'],$_POST['reciver_id'],$_POST['report'],));
echo '<form name="block" action="./talk2.php" method="post">';
    echo '<input type="hidden" name="reciver_id" value="'.$_POST['reciver_id'].'">';
    echo '<SCRIPT language="JavaScript">document.block.submit();</SCRIPT>';
echo '</form>';
?>