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
                            and user.user_id<>?
                            order by user.user_id
                            limit 10');
        // $sql=$pdo->prepare('select user.user_id,icon_image,nick_name,gender,age from user,profile,hobby
        //                     where profile.hobby_id=hobby.hobby_id
        //                     and profile.hobby_id=profile.hobby_id
        //                     and user.user_id<>?
        //                     order by user.user_id
        //                     limit 10');
        $sql->execute(array($_SESSION['user_id']));
        echo '<h2>おすすめ</h2>';
        echo '<div class="recommendation">';
        foreach($sql as $row){
            if($row['gender']==='男性'){
                // アイコンの枠の色を青色に
                echo $row['icon_image'];// アイコン
            }else if($row['gender']==='女性'){
                // アイコンの枠の色を赤色に
                echo $row['icon_image'];// アイコン
            }else{
                // アイコンの枠の色を灰色に
                echo $row['icon_image'];// アイコン
            }
            // アイコンとユーザー名、年齢を表示
            echo '<p>',$row['nick_name'];// ユーザー名
            echo '(',$row['age'],')</p>';// 年齢
        }
        echo '</div>';

        // ランダムに30人を表示する
        $sql=$pdo->prepare('select user.user_id, icon_image, nick_name, gender, age 
                            from user
                            join profile ON user.user_id = profile.user_id
                            order by RAND()
                            limit 30');
        $sql->execute();
        echo '<hr>';
        foreach($sql as $row){
            if($row['gender']==='男性'){
                // アイコンの枠の色を青色に
                echo $row['icon_image'];// アイコン
            }else if($row['gender']==='女性'){
                // アイコンの枠の色を赤色に
                echo $row['icon_image'];// アイコン
            }else{
                // アイコンの枠の色を灰色に
                echo $row['icon_image'];// アイコン
            }
            // アイコンとユーザー名、年齢を表示
            echo '<p>',$row['nick_name'];// ユーザー名
            echo '(',$row['age'],')</p>';// 年齢
        }
        
        ?>
        
    </div>
</body>
</html>