<?php session_start(); ?>
<?php require '../db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
    <div class="header">
        <img src="../image/logo.png" alt="Logo" class="logo">
    </div>
    <div class="content">
        <img src="../image/person1.png" alt="human1" class="side-image">
        <form action="login.php" method="post" class="login-form">
            <div class="form-group">
                <label for="id">E-mail</label>
                <input type="text" id="id" name="id">
            </div>
            <div class="form-group">
                <label for="password">Pass</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit" name="login" value="ログイン">ログイン</button>
        </form>
        <img src="../image/person2.png" alt="human2" class="side-image">
    </div>
    <div class="footer">
        <a href="../kaiin/kaiin1.html">新規登録</a>
    </div>
</div>
</body>
</html>
<?php
    $pdo=new PDO($connect,USER,PASS);
    $sql=$pdo->prepare('select * from user where mail=?');
    if(isset($_POST['login']) && $_POST['login'] === "ログイン"){
        $sql->execute([$_POST['id']]);
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
        var_dump($rows);
        foreach($sql as $row){
            if(password_verify($_POST['password'],$row['password']) == true){//ハッシュ化したパスワードと一致しているか
                $_SESSION['user_id']=$row['user_id'];
                echo var_dump($_SESSION);
            }
        }
        
        if(isset($_SESSION['user_id'])){
            echo <<<EOS
            <script>
            location.href='https://aso2201147.tonkotsu.jp/Friends/top/top.php';
            </script> 
            \n
            EOS;
        }else{
            echo '<p class="error">ログイン名またはパスワードが違います。</p>';
        }
    }
?>