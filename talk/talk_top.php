<?php require '../header.php';?>
<link rel="stylesheet" href="./talk_top.css">
<script src="./script.js"></script>
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
    // 自分の情報を格納する変数
    $current_user = get_user($_SESSION['user']['id']);

    $pdo = new PDO($connect, USER, PASS);
    // トーク内容を取得する変数
    $talk_relations = get_talk_relations($current_user['user_id']);
    if (!empty($talk_relations)) {
        foreach ($talk_relations as $talk_relation) {
            // 自分が送り手なのか受け取り手なのか判定
            if ($talk_relation['reciver_id'] == $current_user['user_id']) {
                $reciver = get_user($talk_relation['user_id']);
            } else {
                $reciver = get_user($talk_relation['reciver_id']);
            }
            $bottom_talk = get_bottom_talk($current_user['user_id'], $reciver['user_id']);
            // 通報したユーザとのトークルームを表示しないようにする
            $report = 'select reporter_id from report where reported_id=?';
            $sql = $pdo->prepare($report);
            $sql->execute([$current_user['user_id']]);
            $result = $sql->fetch();
            if ($result == false || $reciver['user_id'] != $result[0]) {
                $default_icon = '../user_image/main/1.png'; // デフォルトのアイコン画像
                $icon_path = empty($reciver['icon_image']) ? $default_icon : "../user_image/main/{$reciver['icon_image']}";
                echo '<div class="row">';
                    echo '<div class="col-5 offset-2">';
                    echo '<form method="post" action="talk2.php">';
                    echo '<button class="range" type=submit name="submit">';
                        echo '<div class="reciver_list">';
                            // 性別によってアイコン枠の色を変更
                            if ($reciver['gender_id'] === 1) {
                                echo '<div class="frame-blue">';
                            } else if ($reciver['gender_id'] === 2) {
                                echo '<div class="frame-pink">';
                            } else {
                                echo '<div class="frame-gray">';
                            }
                                echo '<a href="../profile/profile-user.php"><img src="'.$icon_path.'" class="talk_user_img"></a>';
                                echo '</div>';
                            echo '<div class="reciver_info">';
                            echo '<input type="hidden" name="reciver_id" value="'.$reciver['user_id'].'">';
                            echo '<div class="content">';
                                echo '<div class="reciver_namea_age">'.$reciver['user_name'].'('.$reciver['age'].')</div>';
                                // なにもメッセージがない場合の判定(if)
                                if (!empty($bottom_talk)) {
                                    echo '<span class="reciver_text">'.$bottom_talk['content'].'</span>';
                                } else {
                                    echo '<span class="reciver_text"></span>';
                                }
                            echo '</div>';
                            echo '<div class="talk_count">';
                            $count = new_message_count2($current_user['user_id'], $reciver['user_id']);
                            if ($count['talk_count'] != 0 && $count['reciver_id'] === $reciver['user_id']) {
                                echo $count['talk_count'];
                            }
                            echo '</div>';
                            $block = 'select * from block where blocker_id=? and blocked_id=?';
                            $sql = $pdo->prepare($block);
                            $sql->execute([$current_user['user_id'], $reciver['user_id']]);
                            if ($sql->fetch()) {
                                echo '<div class="block_message">ブロック中</div>';
                            }
                            echo <<< EOF
                            </div>
                        </div>
                        </button>
                    </form>
                </div>
            </div>
            EOF;
            }
        }
    }?>
    <div class="blank"></div>
</div>
</body>
<!-- 表示するメッセージを制限する -->
<script>
    const limit = document.querySelector(".reciver_text");
    const str = limit.textContent;
    const len = 40; // 半角80字（全角約40字）
    if (str.length > len) {
        limit.textContent = str.substring(0, len) + "…";
    }
</script>
