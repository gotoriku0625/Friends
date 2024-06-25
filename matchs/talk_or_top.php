<?php
session_start();
require '../db-connect.php'; // データベース接続情報を含むファイル

$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ユーザーIDはセッションから取得
$sender_id = $_SESSION['user']['id'];
$reciver_id = $_POST['reciver_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    // talk_memberに登録する
    $stmt = $pdo->prepare("INSERT INTO talk_member (sender_id, reciver_id) VALUES (:sender_id, :reciver_id)");
    $stmt->bindParam(':sender_id', $sender_id);
    $stmt->bindParam(':reciver_id', $reciver_id);
    $stmt->execute();

    // 遷移先を設定
    if ($action == 'talk') {
        header("Location: talk.php?reciver_id=$reciver_id");
    } else {
        header("Location: top.php");
    }
    exit;
}
?>
