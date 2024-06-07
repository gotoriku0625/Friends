<?php require '../menu/menu.php';?>
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
    header('Location:https://aso2201147.tonkotsu.jp/Friends/talk/talk2.php');
    exit;
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
    <div class="message"> 
    <button type=”button” onclick="location.href='./talk_top.php'">戻る</button>
        <h2 class="center"><?=$reciver['user_name']?></h2>
        <?php 
        if($messages!=null){
            foreach ($messages as $message){
                echo '<div class="my_talk">';// トーク画面全体
                // echo var_dump($message);
                if($message['sender_id']==$current_user['user_id']){
                    echo'<div class="mycomment right">';//　自分のメッセージ表示部分↓
                        echo '<p>'.$message['content'].'</p><img src="../user_image/main/'.$current_user['icon_image'].'" class="message_user_img">';
                    echo'</div>';
                }else{
                    echo '<div class="left">';// 相手のメッセージ表示部分↓
                        echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="message_user_img">';
                        echo '<div class="says">'.$message['content'].'</div>';
                    echo '</div>';
                }
                echo '</div>';
            }
        }
        ?>

        <div class="talk_process">
            <h2 class="talk_title">メッセージ</h2>
            <form method="post" action="./talk2.php">
            <textarea id="textarea from-control" type="text" name="text" rows="1" required placeholder="message"></textarea>
                <input type="hidden" name="reciver_id" value="<?= $reciver['user_id']; ?>">
                <div class="talk_btn">
                    <button class="btn btn-outline-primary" type="submit" name="post" value="submit" id="post">送信</button>
                </div>
            </form>
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
