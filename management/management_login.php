<?php session_start(); ?>
<?php require '../db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/management_login.css">
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
    </div>
</div>
</body>
</html>
<?php
    $pdo=new PDO($connect,USER,PASS);
    $sql=$pdo->prepare('select m_user_id from management_user where mail=?');
    if(isset($_POST['login']) && $_POST['login'] === "ログイン"){
        $sql->execute([$_POST['id']]);
        foreach($sql as $row){
            if(password_verify($_POST['m_password'],$row['m_pass']) == true){//ハッシュ化したパスワードと一致しているか
                $_SESSION['m_user_id']=$row['m_user_id'];
            }
        }
        if(isset($_SESSION['m_user_id'])){
            echo <<<EOS
            \n
            EOS;
        }else{
            echo '<p>ログイン名またはパスワードが違います。</p>';
        }
        header('Location:./login.php');
        exit;
    }
?>