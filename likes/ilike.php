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

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../menu/menu.css">
    <title>menu</title>
</head>

<body>
    <div class="menu">
        <div class="logo-space">
            <a href="../top/top.html"><img src="../image/logo.png" class="logo"></a>
        </div>
        <div class="icon"></div>
        <!-- バックエンドの方、ユーザーネームの出力お願いします -->
        <div class="name">ユーザー名</div>
        <div class="link-space">
            <p><img src="../menu-image/parson-free-icon.png" class="parson-free-icon"><a href="../profile/profile.html">プロフィール</a></p>
            <p><img src="../menu-image/seach-free-icon.png" class="seach-free-icon"><a href="../search/search.php">さがす</a></p>
            <p><img src="../menu-image/like-free-icon.png" class="like-free-icon"><a href="../likes/ilike.php">いいね</a></p>
            <p><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../talk/talk.php">トーク</a></p>
            <p><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../community/community.php">コミュニティ</a></p>
            
        </div>
    </div>

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
    <h1>いいねした人の一覧</h1>
    <?php if (!empty($liked_users)): ?>
        <ul class="user-list">
            <?php foreach ($liked_users as $user): ?>
                <li><?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>いいねした人はいません。</p>
    <?php endif; ?>
</body>
</html>