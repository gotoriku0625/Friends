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
        <input type="password" name="name">
    <button type="submit">ログイン</button>
</form>
<form action="../profile/profile-user.html">
    <button type="submit">新規登録</button>
</form>
</body>
</html>

<?php
    $pdo=new PDO($connect,USER,PASS);
    $login=
    foreach($sql as $row){
        if(password_verify($_POST['password'],$row['pass']) == true){//ハッシュ化したパスワードと一致しているか
            $_SESSION['customer']=[
                'id'=>$row['user_id'],'kanji'=>$row['user_name_kanji'],'kana'=>$row['user_name_kana'],'login_mail'=>$row['login_id_mail'],
                'postcode'=>$row['postcode'],'address'=>$row['address'],'phone'=>$row['phone_number'],'password'=>$_POST['password'],'sports'=>$row['sports_id']
            ];
        }
    }
    if(isset($_SESSION['customer'])){
        echo <<<EOS
        <script>
        location.href='https://aso2201147.tonkotsu.jp/Friends/top/Top.php';
        </script> 
        \n
        EOS;
    }else{
        echo '<br><h2>ログイン名またはパスワードが違います。</h2><br>';
        echo '<br><br><a href="../login/login-input.php" class="btn-square-emboss3">ログインへ</a><br><br>';
    }
?>