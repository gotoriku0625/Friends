<?php
session_start();
require '../db-connect.php';


// いいねした人の一覧を取得
$sql_liked = "SELECT user.user_id, user.user_name 
              FROM likes 
              JOIN user ON likes.likes_id = user.user_id 
              WHERE likes.likes_user_id = ?";
$stmt_liked = $conn->prepare($sql_liked);
$stmt_liked->bind_param("i", $logged_in_user_id);
$stmt_liked->execute();
$result_liked = $stmt_liked->get_result();
$liked_users = [];
while ($row = $result_liked->fetch_assoc()) {
    $liked_users[] = $row;
}
$stmt_liked->close();

// いいねされた人の一覧を取得
$sql_liked_by = "SELECT user.user_id, user.user_name 
                 FROM likes 
                 JOIN user ON likes.liked_user_id = user.user_id 
                 WHERE likes.liked_id = ?";
$stmt_liked_by = $conn->prepare($sql_liked_by);
$stmt_liked_by->bind_param("i", $logged_in_user_id);
$stmt_liked_by->execute();
$result_liked_by = $stmt_liked_by->get_result();
$liked_by_users = [];
while ($row = $result_liked_by->fetch_assoc()) {
    $liked_by_users[] = $row;
}
$stmt_liked_by->close();

$conn->close();
?>
<?php require '../menu/menu.html';?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../menu/menu.css">
    <title>menu</title>
    <style>
        .tabs {
            display: flex;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .tab {
            flex: 1;
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }
        .tab.active {
            background-color: #ddd;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
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
    <div class="main">
        <div class="tabs">
            <div class="tab active" onclick="showTab('liked')">いいねした人</div>
            <div class="tab" onclick="showTab('liked_by')">あなたにいいね</div>
        </div>
        <div id="liked" class="tab-content active">
            <?php if (!empty($liked_users)): ?>
                <ul class="user-list">
                    <?php foreach ($liked_users as $user): ?>
                        <li><?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>友達になりたい人を見つけに行きましょう。<img src="../image/person1.png"></p>
            <?php endif; ?>
        </div>
        <div id="liked_by" class="tab-content">
            <?php if (!empty($liked_by_users)): ?>
                <ul class="user-list">
                    <?php foreach ($liked_by_users as $user): ?>
                        <li><?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>いいねをもらった人はいません。<img src="../image/person1.png"></p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            // タブの切り替え
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active');

            // コンテンツの切り替え
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');
        }
    </script>
</body>
</html>
