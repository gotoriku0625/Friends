<?php
session_start();
require '../db-connect.php'; // データベース接続情報を含むファイル

$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ユーザーIDはセッションから取得
$logged_in_user_id = $_SESSION['user']['id'];
$matched_user_id = $_POST['reciver_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    try {
        // talk_memberに登録する
        $sql = "INSERT INTO talk_member (sender_id, reciver_id) VALUES (?, ?), (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$logged_in_user_id, $matched_user_id, $matched_user_id, $logged_in_user_id]);

        // 遷移先を設定
        if ($action == 'talk') {
            header("Location: talk.php?reciver_id=$matched_user_id");
        } else {
            header("Location: top.php");
        }
        exit;
    } catch (PDOException $e) {
        // エラー処理
        echo "エラー: " . $e->getMessage();
    }
}
?>
