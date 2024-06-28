
<div class="menu">
        <div class="logo-space">
            <a href="../top/top.php"><img src="../image/logo.png" class="logo"></a>
        </div>
        <?php
        var_dump($_SESSION)
           //$icon = 
           $_SESSION['management_user']['icon'];
        
            

                // 出力UI確認用に一時置き返してます（後で戻す予定）
                // $icon = "logo.png";
                // 出力UI確認用に一時置き返してます（後で戻す予定）
                //$username = $_SESSION['m_user_id'];
                //$username = $_SESSION['m_user_name'];
                // $username = "sample";
                //echo '<div class="name">',$username,'</div>';
        ?>


        <div class="link-space">
            <p class="textlink textlink04"><a href="../management/Dashboard.php">ダッシュボード</a></p>
            <p class="textlink textlink04"><a href="../management/user_ichiran.php">ユーザー一覧</a></p>
            <p class="textlink textlink04"><a href="../management/tuuhou.php">通報一覧</a></p>
            <p class="textlink textlink04"><a href="../management/kanrisutaffu_settei.php">管理者スタッフ設定</a></p>
            <p class="textlink textlink04"><a href="../community/community.php">ログアウト</a></p>
            
        </div>
    </div>

    <div class="main">
    </div>
<!-- </body> -->
