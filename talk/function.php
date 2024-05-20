<?php
function get_user($user_id){
    try{
        $user='select user_id,user_name,nick_name,icon_image,gender 
              from user u,profile p 
              where u.user_id=p.user_id and u.user_id=:id';
        $sql=$pdo->prepare($user);
        $sql->execute(array(':id' => $user_id));
        return $sql->fetch();
    }catch(\Exception $e){
        error_log('エラー発生：'.$e->getMessage());
        set_flash('error',ERR_MSG1);
    }
}

function get_talks($sender_id,$reciver_id){
    try{
        $talk='select * from talk 
               where (sender_id = :id and reciver_id = :reciver_id) or (sender_id = :reciver_id and reciver_id = :id)
               ORDER BY created_at ASC';
        $sql=$pdo->prepare($talk);
        $sql->execute(array(':id'=>$sender_id,':reciver_id'=>$reciver));
        return $sql->fetchAll();
    }catch(\Exception $e){
        error_log('エラー発生：'.$e->getMessage());
        set_flash('error',ERR_MSG1);
    }
}
?>