
    <div class="menu">
        <div class="logo-space">
            <a href="../top/top.php"><img src="../image/logo.png" class="logo"></a>
        </div>
        <?php

            $icon = $_SESSION['user']['icon'];
            // せしょんにジェンダーはいってたら
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

                $username = $_SESSION['user']['name'];
                echo '<div class="name">',$username,'</div>';
        ?>


        <div class="link-space">
            <p class="textlink textlink04"><img src="../menu-image/parson-free-icon.png" class="parson-free-icon"><a href="../profile/profile.php">プロフィール</a></p>
            <p class="textlink textlink04"><img src="../menu-image/seach-free-icon.png" class="seach-free-icon"><a href="../search/search.php">さがす</a></p>
            <p class="textlink textlink04"> <img src="../menu-image/like-free-icon.png" class="like-free-icon"><a href="../likes/likes.php">いいね</a></p>
            <p class="textlink textlink04"><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../talk/talk_top.php">トーク</a></p>
            <p class="textlink textlink04"><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../community/community.php">コミュニティ</a></p>
            
        </div>
    </div>
