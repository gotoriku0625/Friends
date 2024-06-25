<?php
session_start();
require '../db-connect.php'; // データベース接続情報を含むファイル

$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ログインユーザーIDをセッションから取得
$logged_in_user_id = $_SESSION['user']['id'];

// POSTリクエストからユーザーIDを取得
$liked_user_id = $_POST['user_id'];

if (!$liked_user_id) {
    echo json_encode(['status' => 'error', 'message' => 'ユーザーIDが指定されていません']);
    exit;
}

try {
    // いいねの挿入
    $sql_like = "INSERT INTO likes (likes_user_id, liked_user_id) VALUES (?, ?)";
    $stmt_like = $pdo->prepare($sql_like);
    $stmt_like->execute([$logged_in_user_id, $liked_user_id]);

    // 逆も存在するか確認し、存在すればマッチングを挿入
    $sql_match_check = "SELECT COUNT(*) FROM likes WHERE likes_user_id = ? AND liked_user_id = ?";
    $stmt_match_check = $pdo->prepare($sql_match_check);
    $stmt_match_check->execute([$liked_user_id, $logged_in_user_id]);
    $is_match = $stmt_match_check->fetchColumn() > 0;

    if ($is_match) {
        // マッチングの挿入
        $sql_match = "INSERT INTO matchs (user_id1, user_id2) VALUES (?, ?)";
        $stmt_match = $pdo->prepare($sql_match);
        $stmt_match->execute([$logged_in_user_id, $liked_user_id]);

        // ユーザー名の取得
        $sql_user_name = "SELECT user_name FROM user WHERE user_id = ?";
        $stmt_user_name = $pdo->prepare($sql_user_name);
        $stmt_user_name->execute([$liked_user_id]);
        $user_name = $stmt_user_name->fetchColumn();

        // マッチング成功メッセージの表示
        $_SESSION['match_message'] = $user_name . 'さんとマッチングしましたよ';
        $_SESSION['reciver_id'] = $liked_user_id;

        header("Location: match_success.php");
        exit;
    } else {
        echo json_encode(['status' => 'success', 'message' => 'いいねを送りました']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => '処理中にエラーが発生しました: ' . $e->getMessage()]);
}
?>
