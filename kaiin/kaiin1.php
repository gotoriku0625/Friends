
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規会員登録</title>
    <link rel="stylesheet" href="css/kaiin1.css">
</head>
<body>
    <div id="center">
        <p class="title">新規会員登録</p>
        <hr>
        <form action="kaiin4.php" method="post">
            <div class="input-group">
                <label for="username">ユーザー名:</label>
                <input type="text" id="username" name="name">
            </div>
            <div class="input-group">
                <label for="email">ID/メールアドレス:</label>
                <input type="text" id="email" name="mail">
            </div>
            <div class="input-group">
                <label for="password">パスワード:</label>
                <input type="password" id="password" name="pass">
            </div>
            <button type="submit" class="submit-btn">次へ</button>
        </form>
    </div>
</body>
</html>
