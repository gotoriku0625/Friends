<?php
session_start();
require 'db_connect.php';

// 仮にログインユーザーIDをセッションから取得
$logged_in_user_id = $_SESSION['user_id'];

// マッチングした相手のユーザーIDを仮に指定
$matched_user_id = $_GET['matched_user_id'];

// 自分の情報を取得
$sql = "SELECT user_name, user_icon FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $logged_in_user_id);
$stmt->execute();
$result = $stmt->get_result();
$logged_in_user = $result->fetch_assoc();

// 相手の情報を取得
$sql = "SELECT user_name, user_icon FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $matched_user_id);
$stmt->execute();
$result = $stmt->get_result();
$matched_user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マッチング通知</title>
    <style>
        .user-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin: 20px;
        }
        .user-info div {
            margin-left: 20px;
        }
        .buttons {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>マッチング通知</h1>
    <div class="user-info">
        <img src="path/to/icons/<?php echo htmlspecialchars($logged_in_user['user_icon']); ?>" alt="Your Icon" class="user-icon">
        <div><?php echo htmlspecialchars($logged_in_user['user_name']); ?></div>
    </div>
    <div class="user-info">
        <img src="path/to/icons/<?php echo htmlspecialchars($matched_user['user_icon']); ?>" alt="Matched User Icon" class="user-icon">
        <div><?php echo htmlspecialchars($matched_user['user_name']); ?></div>
    </div>
    <p><?php echo htmlspecialchars($matched_user['user_name']); ?>さんとマッチしました！</p>
    <div class="buttons">
        <button onclick="location.href='talk.php'">はい</button>
        <button onclick="location.href='index.php'">いいえ</button>
    </div>
</body>
</html>
