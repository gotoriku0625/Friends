<?php session_start(); ?>
<?php require '../db-connect.php';?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../menu/menu.css">
    <link rel="stylesheet" href="./talk.css">
    <script type="module" src="./script.js"></script>
    <title>talk</title>
</head>
<?php require './function.php';?>
<?php
$_SESSION['user1_id']=3;
$_SESSION['user2_id']=2;
$current_user = get_user($_SESSION['user1_id']);// 現在ログインしているユーザー情報
// $reciver = get_user($_POST['user_id']);// トーク相手のユーザー情報
$reciver = get_user($_SESSION['user2_id']);
$messages = get_talks($current_user['user_id'],$reciver['user_id']);// やり取りされるメッセージ情報
?>
<body>
<?php require '../menu/menu.php';?>
    <div id="main" class="main">
        <div id="bms_messages_container">
            <div id="bms_chat_header">
                <button type=”button” onclick="location.href='./talk_top.php'">戻る</button>
                <div id="bms_chat_user_status">
                    <div id="bms_status_icon"><img src="../user_image/main/<?=$reciver['icon_image']?>" class="talk_user_img"></div>
                    <div id="bms_chat_user_name"><?=$reciver['user_name']?></div>
                </div>
            </div>
            <?php 
            if($messages!=null){
                echo '<div id="my_talk">';// トーク画面全体
                foreach ($messages as $message){
                    // echo var_dump($message);
                    if($message['sender_id']==$current_user['user_id']){
                        echo'<div class="comment right">';//　自分のメッセージ表示部分↓
                            echo '<div class="talking">';
                                echo '<div class="content">'.nl2br($message['content']).'</div>';
                        echo'</div></div><div class="bms_clear"></div>'; //回り込みを解除（スタイルはcssで充てる)
                    }else{
                        echo '<div class="comment left">';// 相手のメッセージ表示部分↓
                            // echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="message_user_img">';
                            echo '<div class="talking"><div class="content">'.nl2br($message['content']).'</div></div>';
                        echo '</div><div class="bms_clear"></div>';
                    }
                }
                echo '<div id="container" class="container"></div>';
                echo '</div>';
            }
            ?>

            <div id="talk_process">
                <form method="post" action="./talk2-add.php">
                    <textarea class="text" type="text" name="text" required placeholder="message"></textarea>
                    <input type="hidden" name="reciver_id" value="<?= $reciver['user_id']; ?>">
                    <button class="talk_btn" type="submit" name="post" value="submit" id="post">送信</button>
                </form>
            </div>
        </div>
    </div>   
</body>