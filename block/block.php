<?php
require '../db-connect.php';

$pdo=new PDO($connect,USER,PASS);
$block='insert into block values (null,?,?)';
$sql=$pdo->prepare($block);
$sql->execute(array($_SESSION['user']['id'],$_POST['reciver_id']));
echo '<form name="add" action="./talk2.php" method="post">';
    echo '<input type="hidden" name="reciver_id" value="'.$_POST['reciver_id'].'">';
    echo '<SCRIPT language="JavaScript">document.add.submit();</SCRIPT>';
echo '</form>';
?>