<?php
    const SERVER = 'mysql301.phy.lolipop.lan';
    const DBNAME = 'LAA1517801-friends';
    const USER = 'LAA1517801';
    const PASS = 'pass0625';
 
    $connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';
?> 
<?php
function get_user($user_id){// 現在ログインしているユーザー情報
    try{
        $pdo=new PDO($connect,USER,PASS);
        echo var_dump($connect);
        // ユーザ情報取得
        $user='select user_id,user_name,nick_name,icon_image,gender 
              from user u,profile p 
              where u.user_id=p.user_id and u.user_id=:id';
        // $sql=$pdo->prepare($user);
        // $sql->execute(array(':id' => $user_id));
        // return $sql->fetch();
    }catch(\Exception $e){
        echo 'エラー発生：'.$e->getMessage();
    }
}

function get_talks($sender_id,$reciver_id){// やり取りされるメッセージ情報
    try{
        $pdo=new PDO($connect,USER,PASS);
        // トークのユーザー同士の情報を取得する
        $talk='select * from talk 
               where (sender_id = :id and reciver_id = :reciver_id) or (sender_id = :reciver_id and reciver_id = :id)
               ORDER BY created_at ASC';
        $sql=$pdo->prepare($talk);
        $sql->execute(array(':id'=>$user_id,':reciver_id'=>$reciver));
        return $sql->fetchAll();
    }catch(\Exception $e){
        echo 'エラー発生:' . $e->getMessage();
    }
}

function check_relation_talk($user_id,$reciver_id){// talk_memberテーブルに自分のIDと送信先ユーザーのIDがあるかどうか確認
    try{
        $pdo=new PDO($connect,USER,PASS);
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
    try {
      $pdo=new PDO($dsn,$user,$password);
      $sql = "SELECT *
              FROM talk_member
              WHERE user_id = :user_id";
      $stmt = $dbh->prepare($sql);
      $stmt->execute(array(':user_id' => $user_id));
      return $stmt->fetchAll();
    } catch (\Exception $e) {
      echo 'エラー発生:' . $e->getMessage();
    }
  }
  
?>