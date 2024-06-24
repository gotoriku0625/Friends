<?php
session_start();
require '../db-connect.php'; // データベース接続情報を含むファイル

// データベース接続
try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'データベース接続に失敗しました: ' . $e->getMessage()]);
    exit;
}

// ログインユーザーIDをセッションから取得
$logged_in_user_id = $_SESSION['user']['id'];

// POSTリクエストからユーザーIDを取得
$unliked_user_id = $_POST['user_id'];

if (!$unliked_user_id) {
    echo json_encode(['status' => 'error', 'message' => 'ユーザーIDが指定されていません']);
    exit;
}

try {
    // いいねを削除するクエリを実行
    $sql = "DELETE FROM likes WHERE likes_user_id = ? AND liked_user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$logged_in_user_id, $unliked_user_id]);

    // 削除された行数を確認
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'いいねを削除しました']);
    } else {
        echo json_encode(['status' => 'error', 'message' => '指定されたいいねは見つかりませんでした']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'いいね削除中にエラーが発生しました: ' . $e->getMessage()]);
}
?>
