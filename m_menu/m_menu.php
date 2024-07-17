<div class="menu">
        <div class="logo-space">
            <a href="../management/Dashboard.php"><img src="../image/logo.png" class="logo"></a>
        </div>
            <?php
            $username = $_SESSION['m_user_name'];
            echo '<div class="name">',$username,'</div>';
            ?>

        <div class="link-space">
            <p class="textlink textlink04"><a href="../management/Dashboard.php">ダッシュボード</a></p>
            <p class="textlink textlink04"><a href="../management/user_ichiran.php">ユーザー一覧</a></p>
            <p class="textlink textlink04"><a href="../management/tuuhou_ichiran.php">通報一覧</a></p>
            <p class="textlink textlink04"><a href="../management/kanrisutaffu_settei.php">管理者スタッフ設定</a></p>
            <p class="textlink textlink04"><a href="../management/management_logout.php">ログアウト</a></p>
            
        </div>
    </div>

