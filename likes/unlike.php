<?php
session_start();
require '../db-connect.php'; // データベース接続設定を含むファイル

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['liked_user_id'])) {
    $logged_in_user_id = $_SESSION['user']['id'];
    $liked_user_id = $_POST['liked_user_id'];

    $pdo = new PDO($connect, USER, PASS);
    $sql = "DELETE FROM likes WHERE likes_user_id = ? AND liked_user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $logged_in_user_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $liked_user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // リダイレクト先を指定
    header('Location: ../likes/likes.php');
    exit();
}
?>
