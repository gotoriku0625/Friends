<?php require '../db-connect.php';?>
<?php require 'function.php';?>
<?php
$current_user = get_user($_SESSION['user_id']);// 現在ログインしているユーザー情報
$reciver = get_user($_GET['user_id']);// トーク相手のユーザー情報
$messages = get_messages($current_user['id'],$reciver['id']);// やり取りされるメッセージ情報
?>

<body>
    <div class="message"> 
        <h2 class="center"><?= $reciver['user_name']?> </h2>
        <?php foreach ($messages as $message){
            echo '<div class="my_message">';// トーク画面全体
            if($message['user_id']==$current_user['id']){
                echo'<div class="mycomment right">';//　自分のメッセージ表示部分↓
                    echo '<p>'.$message['text'].'</p><img src="../user_image/main/'.$current_user['icon_image'].'" class="message_user_img">';
                echo'</div>';
            }else{
                echo '<div class="left">';// 相手のメッセージ表示部分↓
                    echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="message_user_img">';
                    echo '<div class="says">'.$message['text'].'</div>';
                echo '</div>';
            }
        }?>

        <div class="message_process">
            <h2 class="message_title">メッセージ</h2>
            <form method="post" action="talk2-add.php">
            <textarea id="textarea from-control" type="text" name="text" rows="1" required placeholder="message"></textarea>
                <input type="hidden" name="reciver_id" value="<?= $reciver['id'] ?>">
                <div class="message_btn">
                    <button class="btn btn-outline-primary" type="submit" name="post" value="post" id="post">送信</button>
                </div>
            </form>
        </div>
    </div>   
</body>
</html>

