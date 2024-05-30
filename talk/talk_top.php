<?php session_start(); ?>
<?php require './function.php';?>
<body>

<?php
$_SESSION['user1_id']=1;
$_SESSION['user2_id']=2;
$current_user = get_user($_SESSION['user1_id']);
$reciver = get_user($_SESSION['user2_id']);//本当はGET
$talk_relations = get_talk_relations($current_user['user_id']);
foreach($talk_relations as $talk_relation){
    if($talk_relation['reciver_id']==$current_user['user_id']){
        $reciver = get_user($talk_relation['user_id']);
    }else{
        $reciver = get_user($talk_relation['reciver_id']);
    }
    $bottom_talk = get_bottom_talk($current_user['user_id'],$reciver['user_id']);

echo '<div class="row">';
    echo '<div class="col-8 offset-2">';
        echo '<a href="talk2.php?user_id='.$reciver['user_id'].'">';
        echo '<div class="reciver_list">';
            echo '<img src="../user_image/main'.$reciver['icon_image'].'" class="talk_user_img">';
                echo '<div class="reciver_info">';
                    echo '<div class="reciver_name">'.$reciver['nick_name'].'</div>';
                    echo '<span class="reciver_text">'.$bottom_talk['text'].'</span>';
                echo<<<EOF
                      </div>
             </div>
             </a>
        </div>
    </div>
    EOF;
}?>
</body>
