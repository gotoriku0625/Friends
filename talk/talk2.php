<?php require '../header.php';?>
    <link rel="stylesheet" href="./talk.css">
    <script src="./script.js"></script>
    <title>talk</title>
</head>
<?php require './function.php';?>
<?php
// $_SESSION['user1_id']=3;
// $_SESSION['user2_id']=2;
$current_user = get_user($_SESSION['user']['id']);// 現在ログインしているユーザー情報
$reciver = get_user($_POST['reciver_id']);// トーク相手のユーザー情報
// $reciver = get_user();
$messages = get_talks($current_user['user_id'],$reciver['user_id']);// やり取りされるメッセージ情報
reset_message_count($current_user['user_id'],$reciver['user_id']); 
?>
<body>
<?php require '../menu/menu.php';?>
    <div id="main" class="main">
        <div id="bms_messages_container">
            <div id="bms_chat_header">
                <div id="bms_chat_user_status">
                    <button type=”button” onclick="location.href='./talk_top.php'" class="btn">戻る</button>
                    <?php 
                        if($reciver['gender_id']==='1'){
                            // アイコンの枠の色を青色に
                            echo '<div id="bms_status_icon">';
                                echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="talk_user_img">';
                            echo '</div>';

                        }else if($reciver['gender_id']==='2'){
                            // アイコンの枠の色を赤色に
                            echo '<div id="bms_status_icon">';
                                echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="talk_user_img">';
                            echo '</div>';
                        }else{
                            // アイコンの枠の色を灰色に
                            echo '<div id="bms_status_icon">';
                                echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="talk_user_img">';
                            echo '</div>';
                        }
                    ?>
                    <div id="bms_chat_user_name"><?=$reciver['user_name']?></div>
                    <?php
                    $pdo=new PDO($connect,USER,PASS);
                    $block='select * from block where blocker_id=? and blocked_id=?';
                    $sql=$pdo->prepare($block);
                    $sql->execute([$current_user['user_id'],$reciver['user_id']]);
                    if($sql->fetch()){
                        echo '<div id="block">ブロック中</div>';
                    }?>
                </div>
                <!-- ケバブメニュー(縦に並んでいる黒丸３つのメニュー) -->
                <div id="menu">
                    <nav class="nav-menu">
                        <!-- <ul class="menu-list"> -->
                            <div class="menu-item drop-menu">
                                <a href="#" class="a-all"><span class="dli-more-v"></span></a>
                                <div class="drop-menu-list">
                                    <div class="drop-menu-item open_sub_window_wrapper">
                                        <a href="#" class="a-b open_sub_window" onclick="openSubWindow()">
                                            <img src="../image/block.png" class="block">ブロック</a>
                                    </div>
                                    <!-- サブウィンドウの背景（クリックでサブウィンドウを閉じる） -->
                                    <div class="bg_sub_window" onclick="closeSubWindow()">
                                    <!-- サブウィンドウの内容 -->
                                        <div class="sub_window" onclick="event.stopPropagation()">
                                            <div class="sub_window_content">
                                                <h2 class="title">ブロックしますか？</h2>
                                                <div class="content">
                                                    <form action="../block/block.php" method="post">
                                                        <input type="hidden" name="reciver_id" value="<?$reciver['user_id']?>">
                                                        <button type="submit" class="btn-logout">はい</button>
                                                    </form>
                                                </div>
                                                <button type="submit" class="btn-logout" onclick="closeSubWindow()">いいえ</butto>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="drop-menu-item">
                                        <a href="#" class="a-t open_sub_window" onclick="openSubWindow()">
                                        <img src="../image/report.png" class="report">通報</a>
                                    </div>
                                    <div class="bg_sub_window" onclick="closeSubWindow()">
                                    <!-- サブウィンドウの内容 -->
                                        <div class="sub_window" onclick="event.stopPropagation()">
                                            <div class="sub_window_content">
                                                <h2 class="title"></h2>
                                                <div class="content">
                                                    <form action="../report/report.php" method="post">
                                                        <input type="hidden" name="reciver_id" value="<?$reciver['user_id']?>">
                                                        <input type="radio" name="report" value="性的嫌がらせ">性的嫌がらせ
                                                        <input type="radio" name="report" value="迷惑行為">迷惑行為
                                                        <input type="radio" name="report" value="その他">その他
                                                        <textarea class="" name="text" placeholder="内容を入力してください"></textarea>
                                                        <button type="submit" class="btn-logout">送信</button>
                                                    </form>
                                                </div>
                                                <button type="submit" class="btn-logout" onclick="closeSubWindow()">キャンセル</butto>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </ul> -->
                    </nav>
                </div>
            </div>
            <?php
            if($messages!=null){
                echo '<script>setInterval(fetchUpdates, 2000)</script>';
                // $messages = get_talks($current_user['user_id'],$reciver['user_id']);
                echo '<div id="my_talk">';// トーク画面全体
                    echo '<div id="scroll-inner">';
                foreach ($messages as $message){
                    // echo var_dump($message);
                    if($message['sender_id']==$current_user['user_id']){
                        echo'<div class="comment right">';//　自分のメッセージ表示部分↓
                            echo '<div class="talking">';
                                echo '<div class="content">'.nl2br($message['content']).'</div>';
                        echo'</div></div><div class="bms_clear"></div>'; //回り込みを解除（スタイルはcssで充てる)
                    }else{
                        echo '<div class="comment left">';// 相手のメッセージ表示部分↓
                            // echo '<img src="../user_image/main/'.$reciver['icon_image'].'" class="message_user_img">';
                            echo '<div class="talking"><div class="content">'.nl2br($message['content']).'</div></div>';
                        echo '</div><div class="bms_clear"></div>';
                    }
                }
                // echo '<div id="container" class="container"></div>';
                echo '</div></div>';
            }
            ?>
            
            <?php
            $pdo=new PDO($connect,USER,PASS);
            $block='select * from block where blocker_id=? and blocked_id=?';
            $sql=$pdo->prepare($block);
            $sql->execute([$current_user['user_id'],$reciver['user_id']]);
            if(!$sql->fetch()){
            echo<<<EOF
                <div id="talk_process">
                    <form method="post" action="./talk2-add.php">
                        <textarea class="text" type="text" name="text" required placeholder="message"></textarea>
                        <input type="hidden" name="reciver_id" value="{$reciver['user_id']}">
                        <button class="talk_btn" type="submit" name="post" value="submit" id="post">送信</button>
                    </form>
                </div>
            EOF;
            }?>
        </div>
    </div>
</body>