<?php
$servername = "mysql301.phy.lolipop.lan";
$username = "LAA1517801";
$password = "pass0625";
$dbname = "LAA1517801-friends";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
session_start();
require '../db-connect.php';

// いいねした人の一覧を取得
$sql = "SELECT user.user_id, user.user_name 
        FROM likes 
        JOIN user ON likes.likes_id = user.user_id 
        WHERE likes.likes_user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $logged_in_user_id);
$stmt->execute();
$result = $stmt->get_result();

$liked_users = [];
while ($row = $result->fetch_assoc()) {
    $liked_users[] = $row;
}

$stmt->close();
$conn->close();
?>
<?php require '../menu/menu.html';?>
<head>
    <link rel="stylesheet" href="../menu/menu.css">
</head>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../menu/menu.css">
    <title>menu</title>
</head>

<body>
    <div class="main">
    いいねした人<img src="../menu-image/like-free-icon.png" class=""><button onclick="location.href='./youlike.php'">あなたへいいね</button><img src="../image/unlike.svg" class="">
    <hr></hr>
    <style>
        .user-list {
            list-style-type: none;
            padding: 0;
        }
        .user-list li {
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <?php if (!empty($liked_user)): ?>
        <ul class="user-list">
            <?php foreach ($liked_user as $user): ?>
                <li><?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>友達になりたい人を見つけに行きましょう。<img src="../image/person1.png"></p>
    <?php endif; ?>
</body>
</html>