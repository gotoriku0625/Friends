<?php require '../db-connect.php';?>
<head>
    <meta charset="UTF-8">
    <title>新規会員登録</title>
</head>
<body>
    <p>新規会員登録</p>
    <hr>
<?php
$pdo=new PDO($connect,USER,PASS);
$sql=$pdo->prepare('select * from user where mail=?');
$sql->execute([$_POST['mail']]);
$result=$sql->fetchAll();
if(empty($result)){
    echo '<p>登録完了</p>';
    $pass = password_hash($_POST['pass'],PASSWORD_DEFAULT);//ここでパスワードをハッシュ化
    $sql=$pdo->prepare('insert into user values (null,?,?,?)');
    $sql->execute([
        $_POST['name'],$_POST['mail'],$pass
    ]);
    echo '<button type="submit">プロフィール設定へ</button>';
}else{
    echo '<p>メールアドレスが既に使用されています。</p>';
    echo '<a href="../kaiin/kaiin1.html">新規会員登録へ</a>';
}
?>
</body>