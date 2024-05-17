<?php require '../db-connect.php';?>

<?php
$current_user = get_user($_SESSION['user_id']);
$destination_user = get_user($_GET['user_id']);
$messages = get_messages($current_user['id'],$destination_user['id']);

$pdo=new PDO($connect,USER,PASS);
$imagePath=$pdo->prepare('select icon_image from user,profile where user.user_id=profile.user_id and profile.user_id = ?');
?>

<body>
   <div class="talk-system"> 
    <?php foreach ($messages as $message) :?>
        <div class="mycomment right">
           <p><?php $message['text']?></p><img src='../user_image/main'.<?php 
</body>
</html>