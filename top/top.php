<?php session_start(); ?>
<?php require '../db-connect.php';?>
<?php require '../menu/menu.html';?>
<head>
    <link rel="stylesheet" href="../menu/menu.css">
</head>

<body>
    <div class="main">
        <?php
        $pdo=new PDO($connect,USER,PASS);
        // おすすめ
        $sql=$pdo->prepare('select user.user_id,icon_image,nick_name,gender,age from user,profile,hobby
                            where profile.hobby_id=hobby.hobby_id
                            and profile.hobby_id=profile.hobby_id
                            and user.user_id<>?
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