<?php require '../header.php';?>
<body>
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
                $icon = $_SESSION['user']['icon'];
                echo '</div></div>';
                $username = $_SESSION['user']['name'];
                echo '<div class="name">',$username,'</div>';
        ?>

        <!-- <div class="name">ユーザー名</div> -->
        <div class="link-space">
            <p class="textlink textlink04"><img src="../menu-image/parson-free-icon.png" class="parson-free-icon"><a href="../profile/profile.html">プロフィール</a></p>
            <p class="textlink textlink04"><img src="../menu-image/seach-free-icon.png" class="seach-free-icon"><a href="../profile/search.php">さがす</a></p>
            <p class="textlink textlink04"> <img src="../menu-image/like-free-icon.png" class="like-free-icon"><a href="../profile/ilike.php">いいね</a></p>
            <p class="textlink textlink04"><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../profile/talk.php">トーク</a></p>
            <p class="textlink textlink04"><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../profile/community.php">コミュニティ</a></p>
            
        </div>
    </div>

    <div class="main">
    </div>
</body>
</html>