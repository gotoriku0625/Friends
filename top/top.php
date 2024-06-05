<?php session_start(); ?>
<?php require '../db-connect.php';?>
<?php require '../menu/menu.html';?>
<head>
    <link rel="stylesheet" href="../menu/menu.css">
</head>

<body>
    <div class="main">
        <?php
        if (!isset($_SESSION['user_id'])) {
            die("ユーザーIDが設定されていません。ログインしてください。");
        }
        // $pdo=new PDO($connect,USER,PASS);
        // // おすすめ
        // $sql=$pdo->prepare('select user.user_id,icon_image,nick_name,gender,age from user,profile,hobby
        //                     where profile.hobby_id=hobby.hobby_id
        //                     and profile.hobby_id=profile.hobby_id
        //                     and user.user_id<>?
        //                     order by user.user_id
        //                     limit 10');
        // $sql->execute($_SESSION['user_id']);
        // foreach($sql as $row){
        //     // アイコンとユーザー名、年齢を表示
        //     $row['nick_name'];// ユーザー名
        //     $row['age'];// 年齢
        //     if($row['gender']==='男性'){
        //         // アイコンの枠の色を青色に
        //         $row['icon_image'];// アイコン
        //     }else if($row['gender']==='女性'){
        //         // アイコンの枠の色を赤色に
        //         $row['icon_image'];// アイコン
        //     }else{
        //         // アイコンの枠の色を灰色に
        //         $row['icon_image'];// アイコン
        //     }
        // }

        // // ランダムに30人を表示する
        // $sql=$pdo->prepare('select user.user_id,icon_image,nick_name,gender,age from user,profile
        //                     where user_id=?
        //                     order by user.user_id
        //                     limit 30');
        // foreach($sql as $row){
        //     // アイコンとユーザー名、年齢を表示
        //     $row['nick_name'];// ユーザー名
        //     $row['age'];// 年齢
        //     if($row['gender']==='男性'){
        //         // アイコンの枠の色を青色に
        //         $row['icon_image'];// アイコン
        //     }else if($row['gender']==='女性'){
        //         // アイコンの枠の色を赤色に
        //         $row['icon_image'];// アイコン
        //     }else{
        //         // アイコンの枠の色を灰色に
        //         $row['icon_image'];// アイコン
        //     }
        // }
        try {
            $pdo = new PDO($connect, USER, PASS);
        
            // おすすめ
            $sql = $pdo->prepare('SELECT user.user_id, icon_image, nick_name, gender, age 
                                  FROM user 
                                  JOIN profile ON user.user_id = profile.user_id 
                                  JOIN hobby ON profile.hobby_id = hobby.hobby_id
                                  WHERE user.user_id <> ?
                                  ORDER BY user.user_id
                                  LIMIT 10');
            $sql->execute([$_SESSION['user_id']]);
            foreach ($sql as $row) {
                // アイコンとユーザー名、年齢を表示
                echo $row['nick_name'] . " " . $row['age'] . "<br>";
                if ($row['gender'] === '男性') {
                    // アイコンの枠の色を青色に
                    echo '<div style="border: 2px solid blue;">' . $row['icon_image'] . '</div>';
                } elseif ($row['gender'] === '女性') {
                    // アイコンの枠の色を赤色に
                    echo '<div style="border: 2px solid red;">' . $row['icon_image'] . '</div>';
                } else {
                    // アイコンの枠の色を灰色に
                    echo '<div style="border: 2px solid gray;">' . $row['icon_image'] . '</div>';
                }
            }
        
            // ランダムに30人を表示する
            $sql = $pdo->prepare('SELECT user.user_id, icon_image, nick_name, gender, age 
                                  FROM user 
                                  JOIN profile ON user.user_id = profile.user_id
                                  ORDER BY RAND()
                                  LIMIT 30');
            $sql->execute();
            foreach ($sql as $row) {
                // アイコンとユーザー名、年齢を表示
                echo $row['nick_name'] . " " . $row['age'] . "<br>";
                if ($row['gender'] === '男性') {
                    // アイコンの枠の色を青色に
                    echo '<div style="border: 2px solid blue;">' . $row['icon_image'] . '</div>';
                } elseif ($row['gender'] === '女性') {
                    // アイコンの枠の色を赤色に
                    echo '<div style="border: 2px solid red;">' . $row['icon_image'] . '</div>';
                } else {
                    // アイコンの枠の色を灰色に
                    echo '<div style="border: 2px solid gray;">' . $row['icon_image'] . '</div>';
                }
            }
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        ?>
        ?>
        
    </div>
</body>
</html>