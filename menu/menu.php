<!-- <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     reset.css destyle -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css"/>
    <link rel="stylesheet" href="menu/menu.css">
    <title></title>
</head>
<body> --> 
    <div class="menu">
        <div class="logo-space">
            <a href="../top/top.php"><img src="../image/logo.png" class="logo"></a>
        </div>
        <!-- <div class="icon-space">
            <div class="circle_width">
                <div class="circle_height">
                    <div class="icon"></div>
                </div>
            </div>
        </div> -->

        <?php
            echo '<div class="icon-space">
            <div class="circle_width">
                <div class="circle_height">
                    <div class="icon">';
                // 出力UI確認用に一時置き返してます（後で戻す予定）
                // $icon = $_SESSION['user']['icon'];
                $icon = "logo.png";
                echo '</div></div></div></div>';
                // 出力UI確認用に一時置き返してます（後で戻す予定）
                // $username = $_SESSION['user']['name'];
                $username = "sample";
                echo '<div class="name">',$username,'</div>';
        ?>

        <!-- <div class="name">ユーザー名</div> -->
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
