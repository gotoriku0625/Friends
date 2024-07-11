<?php
session_start();
require '../db-connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO($connect, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $likes_user_id = $_POST['user_id']; // ログインユーザーのID
        $liked_user_id = $_POST['liked_user_id']; // いいねする相手のユーザーID

        // デバッグ情報を表示
        // echo 'likes_user_id: ' . htmlspecialchars($likes_user_id, ENT_QUOTES, 'UTF-8') . '<br>';
        // echo 'liked_user_id: ' . htmlspecialchars($liked_user_id, ENT_QUOTES, 'UTF-8') . '<br>';

        // すでにいいねしているか確認
        $sql_check = 'SELECT COUNT(*) FROM likes WHERE likes_user_id = :likes_user_id AND liked_user_id = :liked_user_id';
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindValue(':likes_user_id', $likes_user_id, PDO::PARAM_INT);
        $stmt_check->bindValue(':liked_user_id', $liked_user_id, PDO::PARAM_INT);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();

        if ($count == 0) {
            // いいねを追加
            $sql = 'INSERT INTO likes (likes_user_id, liked_user_id) VALUES (:likes_user_id, :liked_user_id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':likes_user_id', $likes_user_id, PDO::PARAM_INT);
            $stmt->bindValue(':liked_user_id', $liked_user_id, PDO::PARAM_INT);
            $stmt->execute();

            echo '<p class="message">いいねしました！</p>';
        } else {
            echo '<p class="message">既にいいねしています。</p>';
        }

    } catch (PDOException $e) {
        die("データベース接続に失敗しました: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<link rel="stylesheet" href="css/Like.css">
    <meta charset="UTF-8">
    <title>いいね結果</title>
    <style>
        .bg_pattern {
            background-image: url('path_to_pattern_image'); /* ここに背景パターンの画像パスを指定 */
        }
        .section {
            /* 必要に応じてセクションのスタイルを指定 */
        }
    </style>
</head>
<body>
<div id="center">
    <div class="bg_pattern Polka_v2"></div>
    <div class="section">
        <!-- PHPコードによるいいね結果の表示 -->
    </div>
    <form action="../top/top.php" method="get">
        <button type="submit" class="btn">トップに戻る</button>
    </form>
</div>
</body>
</html>
