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

        $pdo=new PDO($connect,USER,PASS);
        // $r_id='select reciver_id from talk_member where sender_id=?';
        // $sql=$pdo->prepare($r_id);
        // $sql->execute([$_SESSION['user']['id']]);
        // foreach($sql as $row){
        //     // トーク相手の情報を格納する変数
        //     $reciver = get_user($row['reciver_id']);
        // }
            // echo var_dump($reciver);
            // トーク内容を取得する変数
            $talk_relations = get_talk_relations($current_user['user_id']);
            if(!empty($talk_relations)){
            // echo var_dump($talk_relations);
                foreach($talk_relations as $talk_relation){
                    // 自分が送り手なのか受け取り手なのか判定
                    if($talk_relation['reciver_id']==$current_user['user_id']){
                        $reciver = get_user($talk_relation['user_id']);
                    }else{
                        $reciver = get_user($talk_relation['reciver_id']);
                    }
                    $bottom_talk = get_bottom_talk($current_user['user_id'],$reciver['user_id']);
                    // 通報したユーザとのトークルームを表示しないようにする
                    $report='select reporter_id from report where reported_id=?';
                    $sql=$pdo->prepare($report);
                    $sql->execute([$current_user['user_id']]);
                    $result = $sql->fetch();
                    if($result==false||$reciver['user_id']!=$result[0]){
                        echo '<div class="row">';
                            echo '<div class="col-5 offset-2">';
                            echo '<form method="post" action="talk2.php">';
                            echo '<button class="range" type=submit name="submit">';
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
                                        echo '<div class="content">';
                                            echo '<div class="reciver_namea_age">'.$reciver['user_name'].'('.$reciver['age'].')</div>';
                                            // なにもメッセージがない場合の判定(if)
                                            if(!empty($bottom_talk)){
                                                echo '<span class="reciver_text">'.$bottom_talk['content'].'</span>';
                                            }else{
                                                echo '<span class="reciver_text"></span>';
                                            }
                                        echo '</div>';
                                        echo '<div class="talk_count">';
                                        $count = new_message_count2($current_user['user_id'],$reciver['user_id']);
                                        if($count!=false&&($count['talk_count']!=0&&$count['reciver_id']==$reciver['user_id'])){
                                            echo $count['talk_count'];
                                        }
                                        echo '</div>';
                                        $block='select * from block where blocker_id=? and blocked_id=?';
                                        $sql=$pdo->prepare($block);
                                        $sql->execute([$current_user['user_id'],$reciver['user_id']]);
                                        if($sql->fetch()){
                                            echo '<div class="block_message">ブロック中</div>';
                                        }
                                        echo <<< EOF
                                        </div>
                                    </div>
                                    </button>
                                </form>
                                <!-- ケバブメニュー(縦に並んでいる黒丸３つのメニュー) -->
                                <div id="menu">
                                    <nav class="nav-menu">
                                        <!-- <ul class="menu-list"> -->
                                            <div class="menu-item drop-menu">
                                                <a href="#" class="a-all"><span class="dli-more-v"></span></a>
                                                <div class="drop-menu-list">
                                                    <div class="drop-menu-item open_sub_window_wrapper">
                                                        <button class="a-b open_sub_window" onclick="openSubWindow1()">
                                                            <img src="../image/block.png" class="block">ブロック</button>
                                                    </div>
                                                    <!-- サブウィンドウの背景（クリックでサブウィンドウを閉じる） -->
                                                    <div class="bg_sub_window" onclick="closeSubWindow1()">
                                                    <!-- サブウィンドウの内容 -->
                                                        <div class="sub_window" onclick="event.stopPropagation()">
                                                            <div class="sub_window_content">
                                                                <h2 class="title">ブロックしますか？</h2>
                                                                <div class="contents">
                                                                    <form action="./talk2-add.php" method="post">
                                                                        <input type="hidden" name="reciver_id" value="{$reciver['user_id']}">
                                                                        <button type="submit" class="btn-logout" name="check" value="block">はい</button>
                                                                    </form>
                                                                    <button type="submit" class="btn-logout" onclick="closeSubWindow1()">いいえ</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="drop-menu-item">
                                                        <button class="a-t open_sub_window" onclick="openSubWindow2()">
                                                        <img src="../image/report.png" class="report">通報</button>
                                                    </div>
                                                    <!-- サブウィンドウの背景（クリックでサブウィンドウを閉じる） -->
                                                    <div class="bg_sub1_window" onclick="closeSubWindow2()">
                                                    <!-- サブウィンドウの内容 -->
                                                        <div class="sub_window1" onclick="event.stopPropagation()">
                                                            <div class="sub_window_content1">
                                                                <h2 class="title">通報</h2>
                                                                <div class="contents1">
                                                                    <div class="title">通報内容を選択し、内容を入力してください</div>
                                                                    <form action="./talk2-add.php" method="post">
                                                                        <input type="hidden" name="reciver_id" value="{$reciver['user_id']}">
                                                                        <input type="hidden" name="user_id" value="{$current_user['user_id']}">
                                                                        <label id="report"><input type="radio" class="radio" name="report" value="性的嫌がらせ">
                                                                        <div class="moji">性的嫌がらせ</div></label>
                                                                        <label id="report"><input type="radio" class="radio" name="report" value="迷惑行為">
                                                                        <div class="moji">迷惑行為</div></label>
                                                                        <label id="report"><input type="radio" class="radio" name="report" value="その他">
                                                                        <div class="moji">その他</div></label>
                                                                        <div class="area"><textarea class="re_text" type="text" name="re_text" required placeholder="例)裸の写真を要求された"></textarea></div>
                                                                        <!-- <div class="submit"> -->
                                                                        <button type="submit" class="btn-logout">送信</button>
                                                                    </form>
                                                                        <button type="submit" class="btn-logout" onclick="closeSubWindow2()">キャンセル</button>
                                                                        <!-- </div> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- サブウィンドウの背景（クリックでサブウィンドウを閉じる） -->
                                                    <div class="bg_sub_window">
                                                    <!-- サブウィンドウの内容 -->
                                                        <div class="sub_window" onclick="event.stopPropagation()">
                                                            <div class="sub_window_content">
                                                                <h2 class="title">通報を受け付けました</h2>
                                                                <div class="content">
                                                                    <span>引き続き、サービスをお楽しみください</span>
                                                                </div>
                                                                <button type="submit" class="btn-logout" onclick="closeSubWindow()">いいえ</butto>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- </ul> -->
                                    </nav>
                                </div>
                            </div>
                        </div>
                        EOF;
                    }
                }
            }?>
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