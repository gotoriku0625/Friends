<?php session_start(); ?>
<?php require '../db-connect.php';?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../menu/menu.css">
    <link rel="stylesheet" href="./talk.css">
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
try{
    if(isset($_POST['post'])&&$_POST['post']==='submit'){
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

        if(!check_relation_talk($user_id,$reciver_id)){
            $member_add='insert into talk_member(sender_id,reciver_id) values (?,?)';
            $sql=$pdo->prepare($member_add);
            $sql->execute($user_id,$reciver_id);
        }
        echo <<<EOS
        <script>
        window.onload = function() {
            var form = document.getElementById('form');
            var container = document.getElementById('container');
                
            // 下までスクロールする
            var scrollToBottom = () => {
                container.scrollTop = container.scrollHeight;
            };
            
            // 一番下までスクロールしているかどうか
            var isScrollBottom = () => {
                return container.scrollHeight === container.scrollTop + container.offsetHeight;
            };
            
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                e.stopPropagation();
            // 一番下までスクロールされていれば追加後も一番下までスクロールする
                if (isScrollBottom()) {
                    scrollToBottom();
                }
                // 一番下までスクロールされていなければスクロールしない
                else {
                }
            });
        };
        </script> 
        \n
        EOS;
        header("Location: " . $_SERVER['PHP_SELF']);
    }
}catch(Exception $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>
<body>
<?php require '../menu/menu.php';?>
    <div id="main" class="main"> 
        
        <div id="bms_messages_container">
            <div id="bms_chat_header">
                <button type=”button” onclick="location.href='./talk_top.php'">戻る</button>
                <div id="bms_chat_user_status">
                    <div id="bms_status_icon"><?=$reciver['icon_image']?></div>
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
                <form method="post" action="./talk2.php">
                    <textarea class="text" type="text" name="text" rows="1" required placeholder="message"></textarea>
                    <input type="hidden" name="reciver_id" value="<?= $reciver['user_id']; ?>">
                    <button class="talk_btn" type="submit" name="post" value="submit" id="post">送信</button>
                </form>
            </div>
        </div>
    </div>   
</body>