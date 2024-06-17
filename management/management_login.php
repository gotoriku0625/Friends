<?php 
session_start(); 
require '../db-connect.php'; 

try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $pdo->prepare('SELECT m_user_id, m_pass FROM management_user WHERE m_user_id = ?');

    if (isset($_POST['login']) && $_POST['login'] === "ログイン") {
        $sql->execute([$_POST['id']]);
        $management_user = $sql->fetch(PDO::FETCH_ASSOC);
        
        if ($management_user && password_verify($_POST['password'], $management_user['m_pass'])) {
            $_SESSION['m_user_id'] = $management_user['m_user_id'];
            header('Location: ./dashboard.php'); // ログイン成功後にダッシュボードにリダイレクト
            exit;
        } else {
            $error_message = 'ログイン名またはパスワードが違います。';
        }
    }
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
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
        <?php if (isset($error_message)): ?>
            <p><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        <form action="" method="post" class="login-form">
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
