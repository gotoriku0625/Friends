<?php
// ユーザー情報
function get_user($user_id){
    require './db-connect.php';
    try{
        $pdo = new PDO($connect,$user,$pass);
        // ユーザ情報取得
        $user_set='select user.user_id,user_name,gender_id,icon_image,age
               from user,profile 
               where user.user_id=profile.user_id
               and user.user_id=:user_id';
        $sql=$pdo->prepare($user_set);
        // echo var_dump($sql);
        $sql->execute(array(':user_id' => $user_id));
        return $sql->fetch();
    }catch(\Exception $e){
        echo 'エラー発生：'.$e->getMessage();
    }
}
// やり取りされるメッセージ情報
function get_talks($sender_id,$reciver_id){
    require './db-connect.php';
    try{
        $pdo=new PDO($connect,$user,$pass);
        // トークのユーザー同士の情報を取得する
        $talk='select * from talk
               where (sender_id = :sender_id and reciver_id = :reciver_id) 
               or (sender_id = :reciver_id and reciver_id = :sender_id)
               order by talk_id asc';
        $sql=$pdo->prepare($talk);
        $sql->execute(array(':sender_id'=>$sender_id,':reciver_id'=>$reciver_id));
        return $sql->fetchAll();
    }catch(\Exception $e){
        echo 'エラー発生:' . $e->getMessage();
    }
}
 // talk_memberテーブルに自分のIDと送信先ユーザーのIDがあるかどうか確認
function check_relation_talk($user_id,$reciver_id){
    require './db-connect.php';
    try{
        $pdo=new PDO($connect,$user,$pass);
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
// talk_memberの送り手に自分がいるかどうかチェック
function get_talk_relations($user_id){
    require './db-connect.php';
    try {
        $pdo=new PDO($connect,$user,$pass);
        $get = "select *
                from talk_member
                where sender_id = :sender_id";
        $sql = $pdo->prepare($get);
        $sql->execute(array(':sender_id' => $user_id));
        return $sql->fetchAll();
    } catch (\Exception $e) {
        echo 'エラー発生:' . $e->getMessage();
    }
}
// トークの一番下の内容を取得する
function get_bottom_talk($user_id,$reciver_id){
    require './db-connect.php';
    try{
        $pdo=new PDO($connect,$user,$pass);
        $get_talk='select * from talk
                   where (sender_id=:sender_id and reciver_id=:reciver_id)
                   or (sender_id=:reciver_id and reciver_id=:sender_id)
                   order by talk_id desc';
        $sql=$pdo->prepare($get_talk);
        $sql->execute(array(':sender_id'=> $user_id,':reciver_id' => $reciver_id));
        return $sql->fetch();
    }catch (\Exception $e) {
        echo 'エラー発生:' . $e->getMessage();
    }
}
// トークの件数を追加する
function insert_message_count($user_id,$reciver_id){
    require './db-connect.php';
    try{
        $pdo=new PDO($connect,$user,$pass);
        $count='update talk_member
            SET talk_count = talk_count + 1
            WHERE ((sender_id = :sender_id and reciver_id = :reciver_id) 
            or (sender_id = :reciver_id and reciver_id = :sender_id)) 
            and sender_id = :sender_id';
        $sql=$pdo->prepare($count);
        $sql->execute(array(':sender_id'=> $user_id,':reciver_id' => $reciver_id));
        return $sql->fetch();
    }catch (\Exception $e) {
        echo 'エラー発生:' . $e->getMessage();
    }
}
// 自分に来ている未読のメッセージの通知件数を取得する(menu用)
function new_message_count($user_id){
    require '../talk/db-connect.php';
    try{
        $pdo=new PDO($connect,$user,$pass);
        $count='select sum(talk_count)
                from talk_member
                where reciver_id = :sender_id';
        $sql=$pdo->prepare($count);
        $sql->execute(array(':sender_id' => $user_id));
        return $sql->fetch();
    }catch (\Exception $e) {
        echo 'エラー発生:' . $e->getMessage();
    }
}
// 画面を開いたら、通知数をリセット
function reset_message_count($user_id,$reciver_id){
    require './db-connect.php';
    try{
        $pdo=new PDO($connect,$user,$pass);
        $pdo->beginTransaction();
        $reset='update talk_member set talk_count = 0 
        where ((sender_id = :sender_id and reciver_id = :reciver_id) 
        or (sender_id = :reciver_id and reciver_id = :sender_id)) 
        and sender_id = :reciver_id';
        $sql=$pdo->prepare($reset);
        $sql->execute(array(':sender_id'=> $user_id,':reciver_id' => $reciver_id));
        $pdo->commit();
    }catch (\Exception $e) {
        echo 'エラー発生:' . $e->getMessage();
    }
}
?>