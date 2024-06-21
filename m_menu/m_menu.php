
<div class="menu">
        <div class="logo-space">
            <a href="../top/top.php"><img src="../image/logo.png" class="logo"></a>
        </div>
        <?php

            $icon = $_SESSION['user']['icon'];
            var_dump($_SESSION);
            $gender = $_SESSION['user']['gender'];
                if($gender==='男性'){
                    // アイコンの枠の色を青色に
                    echo '<div class="icon-space">
                        <div class="circle_width_man">
                        <div class="circle_height_man">';
                    echo '<img src="../user_image/main/',$icon,'" class="icon">';// アイコン
                    echo '</div></div></div>';
                }else if($gender==='女性'){
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

                // 出力UI確認用に一時置き返してます（後で戻す予定）
                // $icon = "logo.png";
                // 出力UI確認用に一時置き返してます（後で戻す予定）
                $username = $_SESSION['management_user']['m_user_id'];
                $username = $_SESSION['management_user']['m_user_name'];
                // $username = "sample";
                echo '<div class="name">',$username,'</div>';
        ?>


        <div class="link-space">
            <p class="textlink textlink04"><a href="../management/Dashboard.php"></a></p>ダッシュボード
            <p class="textlink textlink04"><a href="../management/user_ichiran.php">ユーザー一覧</a></p>
            <p class="textlink textlink04"><a href="../management/tuuhou.php">通報一覧</a></p>
            <p class="textlink textlink04"><a href="../management/kanrisutaffu_settei.php">管理者スタッフ設定</a></p>
            <p class="textlink textlink04"><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../community/community.php">ログアウト</a></p>
            
        </div>
    </div>

    <div class="main">
    </div>
<!-- </body> -->
