<?php require '../header.php';?>
    <link rel="stylesheet" href="./talk.css">
    <title>talk</title>
</head>
<?php require './function.php';?>
<?php
$_SESSION['user1_id']=3;
$_SESSION['user2_id']=2;
$current_user = get_user($_SESSION['user1_id']);// 現在ログインしているユーザー情報
// $reciver = get_user($_GET['user_id']);// トーク相手のユーザー情報
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
        location.href='https://aso2201147.tonkotsu.jp/Friends/talk/talk2.php';
        </script> 
        \n
        EOS;
    }
    // header('Location:https://aso2201147.tonkotsu.jp/Friends/talk/talk2.php');
    // $rel = $_GET['reload'];
    // if ($rel == 'true') {
    //   header("Location: " . $_SERVER['PHP_SELF']);
    // }
}catch(Exception $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}
?>

<body>
<?php require '../menu/menu.php';?>
    <div class="main"> 
        <button type=”button” onclick="location.href='./talk_top.php'">戻る</button>
        <div id="bms_messages_container">
            <div id="bms_chat_header">
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
                            echo '<div class="content">'.$message['content'].'</div>';
                    echo'</div></div><div class="bms_clear"></div>'; //回り込みを解除（スタイルはcssで充てる)
                }else{
                    echo '<div class="comment left">';// 相手のメッセージ表示部分↓
                        echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="message_user_img">';
                        echo '<div class="talking"><p class="text">'.$message['content'].'</p></div>';
                    echo '</div>';
                }
            }
            echo '</div>';
        }
        ?>

        <div id="talk_process">
            <form method="post" action="./talk2.php">
            <textarea id="textarea from-control" type="text" name="text" id="text" rows="1" required placeholder="message"></textarea>
                <input type="hidden" name="reciver_id" value="<?= $reciver['user_id']; ?>">
                <div id="talk_btn">
                    <button class="btn btn-outline-primary" type="submit" name="post" value="submit" id="post">送信</button>
                </div>
            </form>
        </div>
        </div>
    </div>   
</body>

<?php
// try{
//     if(isset($_POST['post'])&&$_POST['post']==='submit'){
//     $talk_text=$_POST['text'];
//     $user_id=$_SESSION['user1_id'];
//     $reciver_id=$_POST['reciver_id'];
    

//     $talk_text=htmlspecialchars($talk_text,ENT_QUOTES,'UTF-8');
//     $user_id=htmlspecialchars($user_id,ENT_QUOTES,'UTF-8');

//     $pdo=new PDO($connect,USER,PASS);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//     $add='insert into talk(sender_id,reciver_id,content) values (?,?,?)';
//     $sql=$pdo->prepare($add);

//     $data[] = $user_id;
//     $data[] = $reciver_id;
//     $data[] = $talk_text;

//     $sql->execute($data);
//     $pdo=null;

//     if(!check_relation_talk($user_id,$reciver_id)){
//         $member_add='insert into talk_member(sender_id,reciver_id) values (?,?)';
//         $sql=$pdo->prepare($member_add);
//         $sql->execute($user_id,$reciver_id);
//     }
//     header('Location:https://aso2201147.tonkotsu.jp/Friends/talk/talk2.php');
// }
//     // header('Location:https://aso2201147.tonkotsu.jp/Friends/talk/talk2.php');
//     // $rel = $_GET['reload'];
//     // if ($rel == 'true') {
//     //   header("Location: " . $_SERVER['PHP_SELF']);
//     // }
// }catch(Exception $e){
//     echo 'ただいま障害により大変ご迷惑をおかけしております。';
//     exit();
// }
?>
