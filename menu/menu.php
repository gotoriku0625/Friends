
    <div class="menu">
        <div class="logo-space">
            <a href="../top/top.php"><img src="../image/logo.png" class="logo"></a>
        </div>
        <?php
            if($_SESSION['user']['icon']==null){
                $icon_image = '1.png';
            }else{
                $icon = $_SESSION['user']['icon'];
            }
            // せしょんにジェンダーはいってたら
            $gender = $_SESSION['user']['gender'];
                if($gender=== 1){
                    // アイコンの枠の色を青色に
                    echo '<div class="icon-space">
                        <div class="circle_width_man">
                        <div class="circle_height_man">';
                    echo '<img src="../user_image/main/',$icon,'" class="icon">';// アイコン
                    echo '</div></div></div>';
                }else if($gender=== 2){
                    // アイコンの枠の色を赤色に
                    echo '<div class="icon-space">
                        <div class="circle_width_woman">
                        <div class="circle_height_woman">';
                    echo '<img src="../user_image/main/',$icon,'" class="icon">';// アイコン
                    echo '</div></div></div>';
                }else{
                    // アイコンの枠の色を灰色に
                    echo '<div class="icon-space">
                        <div class="circle_width_others">
                        <div class="circle_height_others">';
                    echo '<img src="../user_image/main/',$icon,'" class="icon">';// アイコン
                    echo '</div></div></div>';
                }

                $username = $_SESSION['user']['name'];
                echo '<div class="name">',$username,'</div>';
        ?>


        <div class="link-space">
            <p class="textlink textlink04"><img src="../menu-image/parson-free-icon.png" class="parson-free-icon"><a href="../profile/profile_up.php">プロフィール</a></p>
            <p class="textlink textlink04"><img src="../menu-image/seach-free-icon.png" class="seach-free-icon"><a href="../search/search.php">さがす</a></p>
            <p class="textlink textlink04"> <img src="../menu-image/like-free-icon.png" class="like-free-icon"><a href="../likes/likes.php">いいね</a></p>
            <p class="textlink textlink04"><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../talk/talk_top.php">トーク</a>
            <span class="talk_count">
                <?php
                //トークの件数表示の為のプログラム
                // 自分に来ている未読のメッセージの通知件数を取得する(menu用)
                function new_message_count($user_id){
                    require '../talk/db-connect.php';
                    try{
                        $pdo=new PDO($connect,$user,$pass);
                        $count='select sum(talk_count)
                                from talk_member
                                where reciver_id = :sender_id';
                        $sql=$pdo->prepare($count);
                        $sql->execute(array(':sender_id' => $user_id));
                        return $sql->fetch();
                    }catch (\Exception $e) {
                        echo 'エラー発生:' . $e->getMessage();
                    }
                }
                // echo var_dump(new_message_count($_SESSION['user']['id']));
                if(new_message_count($_SESSION['user']['id']) != 0){  
                    echo new_message_count($_SESSION['user']['id'])[0];  //ココ
                }
                ?>
            </span>
            </p>
        </div>
    </div>

