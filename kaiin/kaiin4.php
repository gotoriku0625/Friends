<?php require '../db-connect.php';?>
<head>
    <meta charset="UTF-8">
    <title>新規会員登録</title>
    <link rel="stylesheet" href="css/kaiin4.css">
</head>
    <body>
        <div id="center">
            <p class="title">新規会員登録</p>
                <hr>
        <?php
            $pdo=new PDO($connect,USER,PASS);
            echo var_dump($pdo);
            $sql=$pdo->prepare('select * from user where mail=?');
            $sql->execute([$_POST['mail']]);
            $result=$sql->fetchAll();
            if(empty($result)){
                echo '<p class="message">登録完了</p>';
                $pass = password_hash($_POST['pass'],PASSWORD_DEFAULT);//ここでパスワードをハッシュ化
                $sql=$pdo->prepare('insert into user values (null,?,?,?)');
                $sql->execute([
                    $_POST['name'],$_POST['mail'],$pass
                ]);
                echo '<a href="../profile/profile.php"><button type="submit">プロフィール設定へ</button></a>';
            }else{
                echo '<p>メールアドレスが既に使用されています。</p>';
                echo '<a href="../kaiin/kaiin1.html" class="btn">新規会員登録へ</a>';
            }
        ?>
        </div>
</body>