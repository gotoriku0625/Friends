<?php require '../header.php';?>
    <link rel="stylesheet" href="talk_top.css">
    <script type="module" src="./script.js"></script>
    <title>Talk Top</title>
</head>
<?php require './function.php';?>
<body>
    <div class="main">
        <div class="talk-head">
            <h1 class="h1-talk">トーク</h1>
            <hr>
        </div>
    <?php require '../menu/menu.php';?>
        <?php
        $pdo=new PDO($connect,USER,PASS);
        $r_id='select reciver_id from talk_member where sender_id=?';
        $sql=$pdo->prepare($r_id);
        $sql->execute([$_SESSION['user']['id']]);
        foreach($sql as $row){
            // 自分の情報を格納する変数
            $current_user = get_user($_SESSION['user']['id']);
            // トーク相手の情報を格納する変数
            $reciver = get_user($row['reciver_id']);
        }
            // echo var_dump($reciver);
            // トーク内容を取得する変数
            $talk_relations = get_talk_relations($current_user['user_id']);
            if(!empty($talk_relations)){
            // echo var_dump($talk_relations);
                // 自分が送り手なのか受け取り手なのか判定
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
                                // 性別によってアイコン枠の色を変更
                                    if($reciver['gender_id'] === 1){
                                        echo '<div class="frame-blue">';
                                    }else if($reciver['gender_id'] === 2){
                                        echo '<div class="frame-pink">';
                                    }else{
                                        echo '<div class="frame-gray">';
                                    }
                                        echo '<a href="../profile/profile-user.php"><img src="../user_image/main/'.$reciver['icon_image'].'" class="talk_user_img"></a>';
                                        echo '</div>';
                                    echo '<div class="reciver_info">';
                                    echo '<input type="hidden" name="reciver_id" value="'.$reciver['user_id'].'">';
                                        echo '<div class="reciver_namea_age">'.$reciver['user_name'].'('.$reciver['age'].')</div>';
                                        // なにもメッセージがない場合の判定(if)
                                        if(!empty($bottom_talk)){
                                            echo '<span class="reciver_text">'.$bottom_talk['content'].'</span>';
                                        }else{
                                            echo '<span class="reciver_text"></span>';
                                        }
                                    echo<<<EOF
                                        </div>
                                </div>
                                </button>
                                </form>
                            </div>
                        </div>
                        EOF;
                    }
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
