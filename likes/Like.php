<?php
session_start();
require '../config.php'; // データベース接続設定ファイルをインクルード

try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTデータを取得
    $profile_id = isset($_POST['profile_id']) ? (int)$_POST['profile_id'] : 0;
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

    if ($profile_id && $user_id) {
        // いいねを挿入するSQLクエリ
        $sql = 'INSERT INTO likes (profile_id, user_id) VALUES (:profile_id, :user_id)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':profile_id', $profile_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // 成功メッセージ
        $message = 'いいねしました！';
    } else {
        // エラーメッセージ
        $message = 'いいねに失敗しました。';
    }
} catch (PDOException $e) {
    $message = 'データベース接続に失敗しました: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>いいね結果</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <p><?php echo htmlspecialchars($message); ?></p>
        <button onclick="location.href='../top/top.php'">トップに戻る</button>
    </div>
</body>
</html>
