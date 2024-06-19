<?php require '../header.php';?>
    <link rel="stylesheet" href="talk_top.css">
    <script type="module" src="./script.js"></script>
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
        echo '<div class="talk-head">';
        echo '<h1 class="h1-talk">トーク</s>';
        echo '<hr></div>';
        echo '<div class="row">';
            echo '<div class="col-8 offset-2">';
            echo '<form method="post" action="talk2.php">';
            echo '<button class="" type=submit name="submit">';
                echo '<div class="reciver_list">';
                    echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="talk_user_img">';
                        echo '<div class="reciver_info">';
                        echo '<input type="hidden" name="reciver_id" value="'.$reciver['user_id'].'">';
                            echo '<div class="reciver_namea_age">'.$reciver['user_name'].'('.$reciver['age'].')</div>';
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
<script>
    const limit = document.querySelector(".reciver_text");
const str = limit.textContent;
const len = 40; // 半角80字（全角約40字）
if (str.length > len) {
  limit.textContent = str.substring(0, len) + "…";
}
</script>