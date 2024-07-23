<?php 
session_start();
require '../db-connect.php';
$user_id=$_SESSION['user']['id'];
$reciver_id= $_SESSION['reciver'];
$pdo=new PDO($connect,USER,PASS);
if(isset($_POST['check'])&&$_POST['check']==='block'){
    $block='insert into block values(null,?,?)';
    $sql=$pdo->prepare($block);
    $sql->execute([$user_id,$reciver_id]);

    echo '<form name="block" action="../talk/talk2.php" method="post">';
        echo '<input type="hidden" name="reciver_id" value="'.$reciver_id.'">';
        unset($_SESSION['reciver']);
        echo '<SCRIPT language="JavaScript">document.block.submit();</SCRIPT>';
    echo '</form>';
}else if(isset($_POST['check'])&&$_POST['check']==='report'){
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
}

?>