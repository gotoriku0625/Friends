<?php session_start();?>
<?php require './function.php';?>
<?php require '../db-connect.php';?>
<!-- <script type="module" src="./script.js"></script> -->
<?php
try{
    // トーク内容の取得
    $talk_text=$_POST['text'];
    // ログインしているユーザーのidの取得
    $user_id=$_SESSION['user']['id'];
    // やり取りしている相手のidの取得
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
    
    // 相手に送ったメッセージの件数を追加する
    insert_message_count($user_id,$reciver_id);
    
    // 自動でフォームを送信する
    echo '<form name="add" action="./talk2.php" method="post">';
        echo '<input type="hidden" name="reciver_id" value="'.$reciver_id.'">';
        echo '<SCRIPT language="JavaScript">document.add.submit();</SCRIPT>';
    echo '</form>';
    exit;
}catch(Exception $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>