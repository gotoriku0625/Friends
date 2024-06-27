<?php require '../header.php';?>
    <link rel="stylesheet" href="./top.css">
    <title>Friends Top</title>
</head>

<body>
<?php require '../menu/menu.php';?>
    <div class="main">
        <?php
        $pdo=new PDO($connect,USER,PASS);
        // おすすめ
        $sql=$pdo->prepare('select user.user_id,icon_image,user_name,gender_name,age from user,profile,hobby,gender
                            where profile.hobby_id=hobby.hobby_id
                            and user.user_id = profile.user_id
                            and gender.gender_id=profile.gender_id
                            and profile.user_id<>?
                            and profile.hobby_id=?
                            order by user.user_id
                            limit 10');
        $sql->execute(array($_SESSION['user']['id'],$_SESSION['user']['hobby']));
        echo '<h2>おすすめ(あなたと共通の趣味)</h2>';
        echo '<div class="recommendation">';
        foreach($sql as $row){
            echo '<div class="user-set">';
            if($row['gender_name']==='男性'){
                // アイコンの枠の色を青色に
                echo '<div class="frame-blue">';
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="best-icon"></a>';// アイコン
                echo '</div>';
            }else if($row['gender_name']==='女性'){
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
        $sql=$pdo->prepare('select user.user_id, icon_image, user_name, gender_name, age 
                            from user,frofile
                            where profile.user_id<>?
                            join profile ON user.user_id = profile.user_id
                            join gender ON gender.gender_id = profile.gender_id
                            order by RAND()
                            limit 30');
        $sql->execute($_SESSION['user']['id']);
        echo '<hr>';
        echo '<div class="recommendation2">';
        foreach($sql as $row){
            echo '<div class="user-set2">';
            if($row['gender_name']==='男性'){
                // アイコンの枠の色を青色に
                echo '<div class="frame-blue2">';
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="standard-icon"></a>';// アイコン
                echo '</div>';
            }else if($row['gender_name']==='女性'){
                // アイコンの枠の色を赤色に
                echo '<div class="frame-pink2">';
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="standard-icon"></a>';// アイコン
                echo '</div>';
            }else{
                // アイコンの枠の色を灰色に
                echo '<div class="frame-gray2">';
                echo '<a href="../profile/profile-user.php"><img src="../user_image/main/',$row['icon_image'],'"class="standard-icon"></a>';// アイコン
                echo '</div>';
            }
            // アイコンとユーザー名、年齢を表示
            echo '<div class="nick_name2">',$row['user_name'],'(',$row['age'],')</div>';
            echo '</div>';
        }
        echo '</div>';
        
        ?>
        
    </div>
</body>
</html>