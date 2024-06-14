<?php 
session_start(); 
require '../db-connect.php'; 

$showAlert = false;

if (isset($_POST['login']) && $_POST['login'] === "ログイン") {
    $pdo = new PDO($connect, USER, PASS);
    $sql = $pdo->prepare('SELECT m_user_id, m_pass FROM management_user WHERE mail = ?');
    $sql->execute([$_POST['id']]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    
    if ($row && password_verify($_POST['password'], $row['m_pass'])) {
        $_SESSION['m_user_id'] = $row['m_user_id'];
        header('Location: ./login.php');
        exit;
    } else {
        $showAlert = true;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/management_login.css">
    <script>
        function showAlert() {
            alert('ログイン名またはパスワードが違います。');
        }
    </script>
</head>
<body>
<?php if ($showAlert): ?>
<script>
    showAlert();
</script>
<?php endif; ?>
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
