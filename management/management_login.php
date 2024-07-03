<?php session_start(); ?>
<?php require '../db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/management_login.css">
</head>
<div class="container">
    <div class="header">
        <img src="../image/logo.png" alt="Logo" class="logo">
    </div>
    <div class="content">
        <img src="../image/person1.png" alt="human1" class="side-image">
        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" id="id" name="id">
            </div>
            <div class="form-group">
                <label for="password">Pass</label>
                <input type="password" id="password" name="password">
            </div>
            <?php if (isset($error_message)): ?>
                <p><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            <button type="submit" name="login" value="ログイン">ログイン</button>
        </form>
        <img src="../image/person2.png" alt="human2" class="side-image">
    </div>
    <div class="footer">
    </div>
    <?php
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $pdo->prepare('SELECT m_user_id,m_user_name, m_pass FROM management_user WHERE m_user_id = ?');

                if (isset($_POST['login']) && $_POST['login'] === "ログイン") {
                    $sql->execute([$_POST['id']]);
                    $management_user = $sql->fetch(PDO::FETCH_ASSOC);

                    // パスワードの確認
                    if ($management_user && $_POST['password'] === $management_user['m_pass']) {
                        $_SESSION['m_user_id'] = $management_user['m_user_id'];
                        $_SESSION['m_user_name'] = $management_user['m_user_name'];
                        header('Location: Dashboard.php'); // ログイン成功後にダッシュボードにリダイレクト
                        exit;
                    } else {
                        $error_message = 'IDまたはパスワードが違います。';
                    }
                }
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    ?>
    
</div>
</body>
</html>
