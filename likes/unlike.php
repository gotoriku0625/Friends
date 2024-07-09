<?php
session_start();
require '../db-connect.php'; // データベース接続設定を含むファイル

if (!isset($_SESSION['user']['id'])) {
    echo 'ログインが必要です。';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logged_in_user_id = $_SESSION['user']['id'];
    
    if (isset($_POST['liked_user_id'])) {
        $liked_user_id = $_POST['liked_user_id'];
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "DELETE FROM likes WHERE likes_user_id = ? AND liked_user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $logged_in_user_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $liked_user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            header('Location: ../likes/likes.php');
            exit();
        } catch (PDOException $e) {
            echo 'データベースエラー: ' . $e->getMessage();
        }
    }
    
    if (isset($_POST['likes_user_id'])) {
        $likes_user_id = $_POST['likes_user_id'];
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "DELETE FROM likes WHERE likes_user_id = ? AND liked_user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $likes_user_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $logged_in_user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            header('Location: ../likes/likes.php');
            exit();
        } catch (PDOException $e) {
            echo 'データベースエラー: ' . $e->getMessage();
        }
    }
}
?>
