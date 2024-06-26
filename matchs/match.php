<?php
session_start();
require '../db-connect.php'; // データベース接続情報を含むファイル

$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ユーザーIDはセッションから取得
$logged_in_user_id = $_SESSION['user']['id'];
$liked_user_id = $_POST['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

            // マッチング成功時の処理
            $_SESSION['match_message'] = 'マッチングしました！';
            $_SESSION['reciver_id'] = $liked_user_id;

            // マッチング成功画面にリダイレクト
            header("Location: match_success.php");
            exit;
        } else {
            // いいねの送信のみの場合
            header('Content-Type: application/json'); // JSONレスポンスのヘッダーを設定
            $response = [
                'status' => 'success',
                'message' => 'いいねを送信しました'
            ];
            echo json_encode($response); // JSONレスポンスを送信
            exit;
        }
    } catch (PDOException $e) {
        // エラー処理
        echo "エラー: " . $e->getMessage();
    }
}

// リクエストがPOSTではない場合や、tryブロック内でエラーが発生した場合の処理
header('Content-Type: application/json'); // JSONレスポンスのヘッダーを設定
$response = [
    'status' => 'error',
    'message' => 'リクエストの処理中にエラーが発生しました'
];
echo json_encode($response); // JSONレスポンスを送信
?>
