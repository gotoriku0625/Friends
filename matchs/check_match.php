<?php
session_start();
require '../db-connect.php'; // パスを確認

// セッションに`user_id`が設定されているか確認
if (!isset($_SESSION['user_id'])) {
    die("ユーザーIDがセッションに設定されていません。");
}

// URLパラメータに`liked_user_id`が設定されているか確認
if (!isset($_GET['liked_user_id'])) {
    die("いいねしたユーザーIDが指定されていません。");
}

$logged_in_user_id = $_SESSION['user_id'];
$liked_user_id = $_GET['liked_user_id'];

// 相互にいいねがあるかをチェック
$sql = "
    SELECT COUNT(*) as match_count
    FROM likes l1
    JOIN likes l2 ON l1.user_id = l2.liked_user_id AND l1.liked_user_id = l2.user_id
    WHERE l1.user_id = ? AND l1.liked_user_id = ?
";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("ステートメントの準備に失敗しました: " . $conn->error);
}
$stmt->bind_param("ii", $logged_in_user_id, $liked_user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['match_count'] > 0) {
    // マッチングが成立した場合、マッチング画面に遷移
    header("Location: matchs.php?matched_user_id=$liked_user_id");
    exit();
} else {
    // マッチングが成立しない場合、メッセージを表示
    echo "マッチングが成立していません。";
}

$stmt->close();
$conn->close();
?>
