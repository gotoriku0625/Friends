<?php
$pdo = new PDO($connect,USER,PASS);
$logged_in_user_id = $_SESSION['user_id']; // ログインユーザーIDをセッションから取得

// いいねした人の一覧を取得
$sql_liked = "SELECT user.user_id, user.user_name, profile.icon_image 
              FROM likes 
              JOIN user ON likes.liked_user_id = user.user_id 
              JOIN profile ON user.user_id = profile.user_id 
              WHERE likes.likes_user_id = ?";
$stmt_liked = $pdo->prepare($sql_liked);
$stmt_liked->bind_param("i", $logged_in_user_id);
$stmt_liked->execute();
$result_liked = $stmt_liked->get_result();
$liked_users = [];
while ($row = $result_liked->fetch_assoc()) {
    $liked_users[] = $row;
}
$stmt_liked->close();

// いいねされた人の一覧を取得
$sql_liked_by = "SELECT user.user_id, user.user_name, profile.icon_image 
                 FROM likes 
                 JOIN user ON likes.likes_user_id = user.user_id 
                 JOIN profile ON user.user_id = profile.user_id 
                 WHERE likes.liked_user_id = ?";
$stmt_liked_by = $pdo->prepare($sql_liked_by);
$stmt_liked_by->bind_param("i", $logged_in_user_id);
$stmt_liked_by->execute();
$result_liked_by = $stmt_liked_by->get_result();
$liked_by_users = [];
while ($row = $result_liked_by->fetch_assoc()) {
    $liked_by_users[] = $row;
}
$stmt_liked_by->close();

$pdo->close();
?>
<?php require '../header.php';?>
    <!-- ↓ここにＣＳＳを追加↓ -->
    <link rel="stylesheet" href="../likes/likes.css">
    <link rel="stylesheet" href="./top.css">
    <title>likes</title>
</head>

<body>
<?php require '../menu/menu.php';?>
    <div class="main">
        <div class="tabs">
            <div class="tab active" onclick="showTab('liked')">いいねした人</div>
            <div class="tab" onclick="showTab('liked_by')">あなたにいいね</div>
        </div>
        <div id="liked" class="tab-content active">
            <?php if (!empty($liked_users)): ?>
                <ul class="user-list">
                    <?php foreach ($liked_users as $user): ?>
                        <li>
                            <img src="../user/image/<?php echo htmlspecialchars($user['icon_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="User Icon">
                            <?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?>
                            <div class="actions">
                                <button onclick="likeUser(<?php echo $user['user_id']; ?>)">いいね</button>
                                <button onclick="unlikeUser(<?php echo $user['user_id']; ?>)">削除</button>
                            </div>
                        </li>
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
                        <li>
                            <img src="../user/image/<?php echo htmlspecialchars($user['icon_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="User Icon">
                            <?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?>
                            <div class="actions">
                                <button onclick="likeUser(<?php echo $user['user_id']; ?>)">いいね</button>
                                <button onclick="unlikeUser(<?php echo $user['user_id']; ?>)">削除</button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>いいねをもらった人はいません。<img src="../image/person1.png"></p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active');

            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');
        }

        function likeUser(userId) {
            // いいねを送る処理をここに追加
            console.log("いいね:", userId);
        }

        function unlikeUser(userId) {
            // いいねを削除する処理をここに追加
            console.log("削除:", userId);
        }
    </script>
</body>
</html>
