<?php
session_start();
 require '../db-connect.php';// データベース接続を含む
$pdo = new PDO($connect, USER, PASS);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id1 = $_POST['user_id1']; // ユーザー1のID
    $user_id2 = $_POST['user_id2']; // ユーザー2のID
 
    // ユーザー2がユーザー1にいいねしているかチェック
    $sql = "SELECT * FROM likes WHERE likes_user_id = ? AND liked_user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue("ii", $user_id2, $user_id1);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($result->num_rows > 0) {
        // マッチングが成立した場合、マッチング情報を挿入
        $sql = "INSERT INTO matchs (user_id1, user_id2) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue("ii", $user_id1, $user_id2);
 
        if ($stmt->execute()) {
            echo "マッチングが成立しました。";
        } else {
            echo "Error: " . $sql . "<br>" . $pdo->error;
        }
    } else {
        echo "まだマッチングしていません。";
    }
 
    $stmt->close();
}
 
$pdo->close();
?>