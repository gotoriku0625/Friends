<?php session_start();?>
<?php require './function.php';?>
<?php require '../db-connect.php';?>
<?php
try{
    $talk_text=$_POST['text'];
    $user_id=$_SESSION['user1_id'];
    $reciver_id=$_POST['reciver_id'];

    $talk_text=htmlspecialchars($talk_text,ENT_QUOTES,'UTF-8');
    $user_id=htmlspecialchars($user_id,ENT_QUOTES,'UTF-8');

    $pdo=new PDO($connect,USER,PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $add='insert into talk(sender_id,reciver_id,content) values (?,?,?)';
    $sql=$pdo->prepare($add);

    $data[] = $user_id;
    $data[] = $reciver_id;
    $data[] = $talk_text;

    $sql->execute($data);
    $pdo=null;

    // if(!check_relation_talk($user_id,$reciver_id)){
    //     $member_add='insert into talk_member(sender_id,reciver_id) values (?,?)';
    //     $sql=$pdo->prepare($member_add);
    //     $sql->execute([$user_id,$reciver_id]);
    // }
    // ブロックしたかどうかの判定
    if(isset($_POST['check'])&&$_POST['check']===1){
        $block='insert into block values(null,?,?)';
        $sql=$pdo->prepare($block);
        $sql->execute([$user_id,$reciver_id]);
        header('Location:./talk2.php?user_id='.$reciver_id.'');
        exit;
    }

    header('Location:./talk2.php?user_id='.$reciver_id.'');
    exit;
}catch(Exception $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>