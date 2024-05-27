<?php
$current_user = get_user($_SESSION['user_id']);
$talk_relations = get_talk_relation($current_user['id']);
foreach($talk_relations as $talk_relation){
    if($talk_relation['reciver_id']==$current_user['id']){
        $reciver = get_user($message_relation['user_id']);
    }else{
        $reciver = get_user($talk_relation['reciver_id']);
    }
    $bottom_talk = get_bottom_talk($current_user['id'],$reciver['id']);

?>

<body>
    <div class="row">
        <div class="col-8 offset-2">
            <a href='talk2.php?user_id=<?=$reciver['id']?>'>
            <div class="reciver_list">
                <img src="../user_image/main<?= $reciver['icon_image']?>" class="talk_user_img">
                <div class="reciver_info">
                    <div class="reciver_name"><?= $reciver['nick_name']?></div>
                    <span class="reciver_text"><?= $bottom_talk['text']?></span>
                </div>
            </div>
            </a>
        </div>
    </div>
<?php } ?>
</body>