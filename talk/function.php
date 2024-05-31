<?php
function get_user($user_id){// 現在ログインしているユーザー情報
    $user = 'LAA1517801';
    $pass = 'pass0625';
    $pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517801-friends;charset=utf8',$user,$pass);
    try{
        // require './db-connect.php';
        $server = 'mysql301.phy.lolipop.lan';
        $dbname = 'LAA1517801-friends';
        $connect = 'mysql:host='. $server . ';dbname='. $dbname . ';charset=utf8';
    
        
        // ユーザ情報取得
        $user='select profile.user_id,user_name,nick_name,gender,icon_image
               from user,profile 
               where user.user_id=profile.user_id
               and profile.user_id=:user_id';
        echo var_dump($pdo);
        $sql=$pdo->prepare($user);
        $result=$sql->bindparam(':user_id',$user_id);
        $result->execute();
        return $result->fetch();
    }catch(\Exception $e){
        echo 'エラー発生：'.$e->getMessage();
    }
}

function get_talks($sender_id,$reciver_id){// やり取りされるメッセージ情報
    require './db-connect.php';
    try{
        $pdo=new PDO($connect,$USER,$PASS);
        // トークのユーザー同士の情報を取得する
        $talk='select * from talk
               where (sender_id = :sender_id and reciver_id = :reciver_id) 
               or (sender_id = :reciver_id and reciver_id = :senderid)
               order by talk_id asc';
        $sql=$pdo->prepare($talk);
        $sql->execute(array(':sender_id'=>$sender_id,':reciver_id'=>$reciver_id));
        return $sql->fetchAll();
    }catch(\Exception $e){
        echo 'エラー発生:' . $e->getMessage();
    }
}

function check_relation_talk($user_id,$reciver_id){// talk_memberテーブルに自分のIDと送信先ユーザーのIDがあるかどうか確認
    require './db-connect.php';
    try{
        $pdo=new PDO($connect,$USER,$PASS);
        $relation='select sender_id,reciver_id
                   from talk_member
                   where (sender_id=:sender_id and reciver_id=:reciver_id)
                   or (sender_id=:reciver_id and reciver_id=:sender_id)';
        $sql=$pdo->prepare($relation);
        $sql->execute(array(':sender_id'=>$user_id,
                            ':reciver_id'=>$reciver_id));
        return $sql->fetch();
    }catch(\Exception $e){
        echo 'エラー発生:' . $e->getMessage();
    }
}

function get_talk_relations($user_id){
    require './db-connect.php';
    try {
      $pdo=new PDO($connect,$USER,$PASS);
      $sql = "select *
              FROM talk_member
              WHERE sender_id = :sender_id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(':sender_id' => $user_id));
      return $stmt->fetchAll();
    } catch (\Exception $e) {
      echo 'エラー発生:' . $e->getMessage();
    }
}
  
function get_bottom_talk($user_id,$reciver_id){
    try{
        require './db-connect.php';
        $pdo=new PDO($connect,$USER,$PASS);
        $get_talk='select * from talk
                   where (sender_id=:sender_id and reciver_id=reciver_id)
                   or (user_id=:reciver_id and reciver_id=:sender_id)
                   order by talk_id desc';
        $sql=$pdo->prepare($get_talk);
        $sql->execute(array(':sender_id'=> $user_id,':reciver_id' => $reciver_id));
        return $sql->fetch();
    }catch (\Exception $e) {
        echo 'エラー発生:' . $e->getMessage();
    }
}

?>