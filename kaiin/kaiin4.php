<?php session_start(); ?>
<?php require '../db-connect.php';?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- reset.css destyle -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css"/>
    <link rel="stylesheet" href="css/kaiin4.css">
    <title>新規会員登録</title>
</head>
    <body>
        <div id="center">
            <p class="title">新規会員登録</p>
                <hr>
        <?php
            $pdo=new PDO($connect,USER,PASS);
            if($_POST['name']&&$_POST['mail']&&$_POST['pass']){
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
                    echo '<a href="../profile/profile.php"><button type="submit" class="btn">プロフィール設定へ</button></a>';
                    $sql=$pdo->prepare('select * from user where mail=?');
                    $sql->execute([$_POST['mail']]);
                    foreach($sql as $row){
                        $_SESSION['user']=[
                            'id'=>$row['user_id'],'name'=>$row['user_name']
                        ];
                    }
                }else{
                    echo '<p>メールアドレスが既に使用されています</p>';
                    echo '<a href="../kaiin/kaiin1.html" class="btn">新規会員登録へ</a>';
                }
            }else{
                echo '<p>全て入力されていません</p>';
                echo '<a href="../kaiin/kaiin1.html" class="btn">新規会員登録へ</a>';
            }
            
        ?>
        </div>
</body>