<div class="menu">
    <div class="logo-space">
        <a href="../top/top.php"><img src="../image/logo.png" class="logo"></a>
    </div>
    <?php
        // アイコンが設定されていない場合のデフォルトアイコンパス
        $default_icon = '../user_image/main/1.png';
        // 現在のユーザーアイコンパス
        $icon_path = empty($_SESSION['user']['icon']) ? $default_icon : "../user_image/main/{$_SESSION['user']['icon']}";

        // アイコンと性別に応じた枠の色を設定
        $gender = $_SESSION['user']['gender'];
        if ($gender === 1) {
            echo '<div class="icon-space">
                    <div class="circle_width_man">
                        <div class="circle_height_man">';
        } elseif ($gender === 2) {
            echo '<div class="icon-space">
                    <div class="circle_width_woman">
                        <div class="circle_height_woman">';
        } else {
            echo '<div class="icon-space">
                    <div class="circle_width_others">
                        <div class="circle_height_others">';
        }
        // アイコンの表示
        echo '<img src="' . $icon_path . '" class="icon">';
        echo '</div></div></div>';

        // ユーザー名の表示
        $username = $_SESSION['user']['name'];
        echo '<div class="name">' . $username . '</div>';
    ?>


    <div class="link-space">
        <!-- プロフィールリンク -->
        <p class="textlink textlink04">
            <img src="../menu-image/parson-free-icon.png" class="parson-free-icon">
            <a href="../profile/profile_up.php">プロフィール</a>
        </p>
        <!-- 検索リンク -->
        <p class="textlink textlink04">
            <img src="../menu-image/seach-free-icon.png" class="seach-free-icon">
            <a href="../search/search.php">さがす</a>
        </p>
        <!-- いいねリンク -->
        <p class="textlink textlink04">
            <img src="../menu-image/like-free-icon.png" class="like-free-icon">
            <a href="../likes/likes.php">いいね</a>
        </p>
        <!-- トークリンク -->
        <p class="textlink textlink04">
            <img src="../menu-image/talk-free-icon.png" class="talk-free-icon">
            <a href="../talk/talk_top.php">トーク</a>
            <!-- 未読メッセージ件数 -->
            <span class="talk_count">
                <?php
                // 未読メッセージ件数を取得する関数
                function new_message_count($user_id){
                    require '../talk/db-connect.php';
                    try {
                        $pdo = new PDO($connect, $user, $pass);
                        $count = 'select sum(talk_count) from talk_member where reciver_id = :sender_id';
                        $sql = $pdo->prepare($count);
                        $sql->execute(array(':sender_id' => $user_id));
                        return $sql->fetch();
                    } catch (\Exception $e) {
                        echo 'エラー発生:' . $e->getMessage();
                    }
                }
                
                // 未読メッセージ件数を表示
                if(new_message_count($_SESSION['user']['id'])[0] <> 0){  
                    echo new_message_count($_SESSION['user']['id'])[0];  
                }
                ?>
            </span>
        </p>
    </div>
</div>
