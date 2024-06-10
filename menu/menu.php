
    <div class="menu">
        <div class="logo-space">
            <a href="../top/top.php"><img src="../image/logo.png" class="logo"></a>
        </div>
        <?php

                if($_SESSION['gender']==='男性'){
                    // アイコンの枠の色を青色に
                    echo '<div class="icon-space">
                        <div class="circle_width">
                        <div class="circle_height">';
                    $icon = $_SESSION['user']['icon'];
                    echo '<img src="',$icon,'" class="icon">';// アイコン
                    echo '</div></div></div>';
                }else if($_SESSION['gender']==='女性'){
                    // アイコンの枠の色を赤色に
                    echo '<div class="icon-space">
                        <div class="circle_width">
                        <div class="circle_height">';
                    $icon = $_SESSION['user']['icon'];
                    echo '<img src="',$icon,'" class="icon">';// アイコン
                    echo '</div></div></div>';
                }else{
                    // アイコンの枠の色を灰色に
                    echo '<div class="icon-space">
                        <div class="circle_width">
                        <div class="circle_height">';
                    $icon = $_SESSION['user']['icon'];
                    echo '<img src="',$icon,'" class="icon">';// アイコン
                    echo '</div></div></div>';
                }

                // 出力UI確認用に一時置き返してます（後で戻す予定）
                $icon = "logo.png";
                // 出力UI確認用に一時置き返してます（後で戻す予定）
                // $username = $_SESSION['user']['name'];
                $username = "sample";
                echo '<div class="name">',$username,'</div>';
        ?>


        <div class="link-space">
            <p class="textlink textlink04"><img src="../menu-image/parson-free-icon.png" class="parson-free-icon"><a href="../profile/profile.html">プロフィール</a></p>
            <p class="textlink textlink04"><img src="../menu-image/seach-free-icon.png" class="seach-free-icon"><a href="../search/search.php">さがす</a></p>
            <p class="textlink textlink04"> <img src="../menu-image/like-free-icon.png" class="like-free-icon"><a href="../likes/ilike.php">いいね</a></p>
            <p class="textlink textlink04"><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../talk/talk_top.php">トーク</a></p>
            <p class="textlink textlink04"><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../community/community.php">コミュニティ</a></p>
            
        </div>
    </div>

    <div class="main">
    </div>
<!-- </body> -->
