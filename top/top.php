<?php require '../header.php';?>
    <!-- ↓ここにＣＳＳを追加↓ -->
    <link rel="stylesheet" href="./top.css">
    <title>Friends Top</title>
</head>

<body>
<?php require '../menu/menu.php';?>
    <div class="main">
        <?php
        $pdo=new PDO($connect,USER,PASS);
        // おすすめ
        $sql=$pdo->prepare('select user.user_id,icon_image,user_name,gender_id,age from user,profile,hobby,gender
                            where profile.hobby_id=hobby.hobby_id
                            and user.user_id<>?
                            order by user.user_id
                            limit 10');
        $sql->execute(array($_SESSION['user']['id']));
        echo '<h2>おすすめ</h2>';
        echo '<div class="recommendation">';
        foreach($sql as $row){
            echo '<div class="user-set">';
            if($row['gender_id']==='男性'){
                // アイコンの枠の色を青色に
                echo '<div class="frame-blue">';
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="best-icon"></a>';// アイコン
                echo '</div>';
            }else if($row['gender_id']==='女性'){
                // アイコンの枠の色を赤色に
                echo '<div class="frame-pink">';
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="best-icon"></a>';// アイコン
                echo '</div>';
            }else{
                // アイコンの枠の色を灰色に
                echo '<div class="frame-gray">';
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="best-icon"></a>';// アイコン
                echo '</div>';
            }
            // アイコンとユーザー名、年齢を表示
            echo '<div class="nick_name1">',$row['user_name'],'(',$row['age'],')</div>';
            echo '</div>';
        }
        echo '</div>';

        // ランダムに30人を表示する
        $sql=$pdo->prepare('select user.user_id, icon_image, user_name, gender_id, age 
                            from user
                            join profile ON user.user_id = profile.user_id
                            order by RAND()
                            limit 30');
        $sql->execute();
        echo '<hr>';
        foreach($sql as $row){
            echo '<div class="user-set">';
            if($row['gender_id']==='男性'){
                // アイコンの枠の色を青色に
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="standard-icon"></a>';// アイコン
            }else if($row['gender_id']==='女性'){
                // アイコンの枠の色を赤色に
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="standard-icon"></a>';// アイコン
            }else{
                // アイコンの枠の色を灰色に
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="standard-icon"></a>';// アイコン
            }
            // アイコンとユーザー名、年齢を表示
            echo '<div class="nick_name2">',$row['user_name'],'(',$row['age'],')</div>';
            echo '</div>';
        }
        
        ?>
        
    </div>
</body>
</html>