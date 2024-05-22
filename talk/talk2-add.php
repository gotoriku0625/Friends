<?php require '../db-connect.php';?>
<?php
$pdo=new PDO($connect,USER,PASS);
try{
    $talk_text=$_POST['text'];
    $user_id=$_SESSION['user_id'];
    $reciver_id=$_POST['reciver_id'];

    if($talk_text==''){
        reload();
    }

    $talk_text=htmlspecialchars($talk_text,ENT_QUOTES,'UTF-8');
    $user_id=htmlspecialchars($user_id,ENT_QUOTES,'UTF-8');

    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $add='insert into talk(sender_id,reciver_id,content) values (?,?,?)';
    $sql=$pdo->prepare($add);

    $data[] = $talk_text;
    $data[] = $user_id;
    $data[] = $reciver_id;

    $sql->execute($data);
    $pdo=null;

    if(!check_relation_talk($user_id,$reciver_id)){
        insert_talk($user_id,$reciver_id);
    }
    header('Location:talk.php?user_id='.$reciver_id.'');
}catch(Exception $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>