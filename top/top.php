<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../menu/menu.css">
    <title>top</title>
</head>

<body>
    <div class="menu">
        <div class="logo-space">
            <a href="../top/top.html"><img src="../image/logo.png" class="logo"></a>
        </div>
        <div class="icon"></div>
        <!-- バックエンドの方、ユーザーネームの出力お願いします -->
        <div class="name">ユーザー名</div>
        <div class="link-space">
            <p><img src="../menu-image/parson-free-icon.png" class="parson-free-icon"><a href="../profile/profile.html">プロフィール</a></p>
            <p><img src="../menu-image/seach-free-icon.png" class="seach-free-icon"><a href="../profile/search.php">さがす</a></p>
            <p><img src="../menu-image/like-free-icon.png" class="like-free-icon"><a href="../profile/ilike.php">いいね</a></p>
            <p><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../profile/community.php">コミュニティ</a></p>
            <p><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../profile/talk.php">トーク</a></p>
        </div>
    </div>

    <div class="main">
        <?php
        $pdo=new PDO($connect,USER,PASS);
        // おすすめ
        $sql=$pdo->prepare('select user.user_id,icon_image,nick_name,gender,age from user,profile,hobby
                            where profile.hobby_id=hobby.hobby_id
                            and profile.hobby_id=profile.hobby_id
                            and user_id!=?
                            order by user.user_id
                            limit 10');
        $sql->execute($_SESSION['user_id']);
        foreach($sql as $row){
            // アイコンとユーザー名、年齢を表示
            $row['nick_name'];// ユーザー名
            $row['age'];// 年齢
            if($row['gender']==='男性'){
                // アイコンの枠の色を青色に
                $row['icon_image'];// アイコン
            }else if($row['gender']==='女性'){
                // アイコンの枠の色を赤色に
                $row['icon_image'];// アイコン
            }else{
                // アイコンの枠の色を灰色に
                $row['icon_image'];// アイコン
            }
        }

        // ランダムに30人を表示する
        $sql=$pdo->prepare('select user.user_id,icon_image,nick_name,gender,age from user,profile
                            where user_id=?
                            order by user.user_id
                            limit 30');
        foreach($sql as $row){
            // アイコンとユーザー名、年齢を表示
            $row['nick_name'];// ユーザー名
            $row['age'];// 年齢
            if($row['gender']==='男性'){
                // アイコンの枠の色を青色に
                $row['icon_image'];// アイコン
            }else if($row['gender']==='女性'){
                // アイコンの枠の色を赤色に
                $row['icon_image'];// アイコン
            }else{
                // アイコンの枠の色を灰色に
                $row['icon_image'];// アイコン
            }
        }
        ?>
        
    </div>
</body>
</html>