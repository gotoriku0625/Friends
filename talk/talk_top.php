<?php require '../header.php';?>
    <link rel="stylesheet" href="../talk_top.css">
    <title>Talk Top</title>
</head>
<?php require './function.php';?>
<body>
    <div class="main">
<?php require '../menu/menu.php';?>
<?php
$_SESSION['user1_id']=3;
$_SESSION['user2_id']=2;
$current_user = get_user($_SESSION['user1_id']);
$reciver = get_user($_SESSION['user2_id']);//本当はGET
// echo var_dump($reciver);
$talk_relations = get_talk_relations($current_user['user_id']);
// echo var_dump($talk_relations);
foreach($talk_relations as $talk_relation){
    if($talk_relation['reciver_id']==$current_user['user_id']){
        $reciver = get_user($talk_relation['user_id']);
    }else{
        $reciver = get_user($talk_relation['reciver_id']);
    }
    $bottom_talk = get_bottom_talk($current_user['user_id'],$reciver['user_id']);

echo '<div class="row">';
    echo '<div class="col-8 offset-2">';
    echo '<form method="post" action="talk2.php">';
    echo '<button class="" type=submit name="submit">';
        echo '<div class="reciver_list">';
            echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="talk_user_img">';
                echo '<div class="reciver_info">';
                echo '<input type="hidden" name="reciver_id" value="'.$reciver['user_id'].'">';
                    echo '<div class="reciver_name">'.$reciver['user_name'].'</div>';
                    echo '<div class="reciver_age">'.$reciver['age'].'</div>';
                    echo '<span class="reciver_text">'.$bottom_talk['content'].'</span>';
                echo<<<EOF
                      </div>
             </div>
            </button>
            </form>
        </div>
    </div>
    EOF;
}?>
    </div>
</body>
