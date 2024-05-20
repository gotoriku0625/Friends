<?php require '../db-connect.php';?>
<?php require 'function.php';?>
<?php
$current_user = get_user($_SESSION['user_id']);
$destination_user = get_user($_GET['user_id']);
$messages = get_messages($current_user['id'],$reciver['id']);

$pdo=new PDO($connect,USER,PASS);
$imagePath='select icon_image from user,profile where user.user_id=profile.user_id and profile.user_id = :user_id';
$sql=$pdo->prepare($imagePath);
?>

<body>
    <div class="message"> 
        <?php foreach ($messages as $message){
            echo '<div class="my_message">';
            if($message['user_id']==$current_user['id']){
            $sql->bindParam(':user_id',$current_user,PDO::PARAM_STR);
                echo'<div class="mycomment right">';
                    <p>.$message['text'].</p><img src="../user_image/main/.$sql->execute()." class="message_user_img">
                </div>
                EOF;
            }else{
                $sql->bindParam(':user_id',$reciver,PDO::PARAM_STR);
                echo<<<EOF
                <div class="left">
                    <img src="../user_image/main/$sql->execute()" class="message_user_img">
                    <div class="says">
                        $message['text']
                    </div>
                </div>
                EOF;
            }
        }?>

        <div class="message_process">
            <h2 class="message_title">メッセージ</h2>
            <form method="post" action="talk.php#talk-area">
            <textarea id="textarea" type="text" name="text" rows="1" required placeholder="message"></textarea>
                <input type="hidden" name="reciver_id" value="<?= $reciver_user['id'] ?>">
                <div class="message_btn">
                    <button class="btn btn-outline-primary" type="submit" name="post" value="post" id="post">送信</button>
                </div>
            </form>
        </div>
    </div>   
</body>
</html>

