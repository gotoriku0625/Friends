<?php require '../db-connect.php';?>

<?php
$current_user = get_user($_SESSION['user_id']);
$destination_user = get_user($_GET['user_id']);
$messages = get_messages($current_user['id'],$destination_user['id']);

$pdo=new PDO($connect,USER,PASS);
$imagePath='select icon_image from user,profile where user.user_id=profile.user_id and profile.user_id = :user_id';
$sql=$pdo->prepare($imagePath);
?>

<body>
   <div class="message"> 
    <?php foreach ($messages as $message) :?>
        <div class="my_message">
        <?php if($message['user_id']==$current_user['id']):?>
            <?php $sql->bindParam(':user_id',$current_user,PDO::PARAM_STR); ?>
            <div class="mycomment right">
                <p><?php $message['text']?></p><img src="../user_image/main<?php $sql->execute();?>" class="message_user_img">
            </div>
        <?php else :?>
            <?php $sql->bindParam(':user_id',$destination_user,PDO::PARAM_STR); ?>
            <div class="left">
                <img src="../user_image/main<?php $sql->execute();?>" class="message_user_img">
                <div class="says">
                    <?php $message['text']?>
                </div>
        <?php endif;?>
            </div>
    <?php endforeach?>
        
</body>
</html>