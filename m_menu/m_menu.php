
<div class="menu">
        <div class="logo-space">
            <a href="../top/top.php"><img src="../image/logo.png" class="logo"></a>
        </div>
        <?php

        if (isset($array['management_user'])) {
    // 配列キーが存在する場合のみアクセスする
        $value = $array['management_user'];
        } else {
    // 配列キーが存在しない場合の処理
        $value = null; // 必要に応じて適切なデフォルト値を設定
        }


           $icon = $_SESSION['management_user']['icon'];
        
            

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
