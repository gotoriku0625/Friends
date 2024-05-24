<?php session_start();?>
<?php require '../db-connect.php';?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<img src="../image/logo.png" alt="Logo"width="200" height="200">
<img src="../image/person1.png" alt="human1"width="200" height="200">
<img src="../image/person2.png" alt="human2"width="200" height="200">
<form action="login.php" method="post">
    <p>ID</p>
        <input type="text" name="id">
    <p>pass</p>
        <input type="password" name="password">
    <button type="submit" name="login" value="ログイン">ログイン</button>
</form>
    <a href="../kaiin/kaiin1.html">新規会員登録</a>
</body>
</html>

<?php
    $pdo=new PDO($connect,USER,PASS);
    $sql=$pdo->prepare('select user_id from user where mail=?');
    if(isset($_POST['login']) && $_POST['login'] === "ログイン"){
        $sql->execute([$_POST['id']]);
        foreach($sql as $row){
            if(password_verify($_POST['password'],$row['password']) == true){//ハッシュ化したパスワードと一致しているか
                $_SESSION['user_id']=$row['user_id'];
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
            echo '<p>ログイン名またはパスワードが違います。</p>';
        }
        header('Location:./login.php');
        exit;
    }
?>