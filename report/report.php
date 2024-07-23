<?php
require '../db-connect.php';

$pdo=new PDO($connect,USER,PASS);
// 通報
$report='insert into report values (null,?,?,?,?)';
$sql=$pdo->prepare($report);
$sql->execute(array($_POST['user_id'],$_POST['reciver_id'],$_POST['report'],$_POST['re_text']));
// ブロック
$block='insert into block values(null,?,?)';
$sql=$pdo->prepare($block);
$sql->execute([$_POST['user_id'],$_POST['reciver_id']]);

echo '<form name="report" action="../talk/talk2.php" method="post">';
    echo '<input type="hidden" name="reciver_id" value="'.$_POST['reciver_id'].'">';
    echo '<SCRIPT language="JavaScript">document.report.submit();</SCRIPT>';
echo '</form>';
?>