<?php require '../header.php'; ?>
<link rel="stylesheet" href="../likes/likes.css?v=1.0.1">
<title>likes</title>
</head>
<?php
$pdo = new PDO($connect, USER, PASS);
$logged_in_user_id = $_SESSION['user']['id']; // ログインユーザーIDをセッションから取得

// いいねした人の一覧を取得
$sql_liked = "SELECT user.user_id, user.user_name, profile.icon_image, profile.age 
              FROM likes 
              JOIN user ON likes.liked_user_id = user.user_id 
              JOIN profile ON user.user_id = profile.user_id 
              WHERE likes.likes_user_id = ?";
$stmt_liked = $pdo->prepare($sql_liked);
$stmt_liked->bindValue(1, $logged_in_user_id, PDO::PARAM_INT);
$stmt_liked->execute();
$liked_users = $stmt_liked->fetchAll(PDO::FETCH_ASSOC);
$stmt_liked->closeCursor();

// いいねされた人の一覧を取得
$sql_liked_by = "SELECT user.user_id, user.user_name, profile.icon_image, profile.age 
                 FROM likes 
                 JOIN user ON likes.likes_user_id = user.user_id 
                 JOIN profile ON user.user_id = profile.user_id 
                 WHERE likes.liked_user_id = ?";
$stmt_liked_by = $pdo->prepare($sql_liked_by);
$stmt_liked_by->bindValue(1, $logged_in_user_id, PDO::PARAM_INT);
$stmt_liked_by->execute();
$liked_by_users = $stmt_liked_by->fetchAll(PDO::FETCH_ASSOC);
$stmt_liked_by->closeCursor();
?>
<body>
<?php require '../menu/menu.php'; ?>
<div class="main">
    <div class="fiex">
        <div class="tabs">
            <div class="tab active" onclick="showTab('liked')">いいねした人<img src="../menu-image/like-free-icon.png" width="40" height="40"></div>
            <div class="tab" onclick="showTab('liked_by')">あなたにいいね<img src="../image/you.png" width="40" height="40"></div>
        </div>
    </div>
    <div id="liked" class="tab-content active">
    <?php if (!empty($liked_users)): ?>
        <ul class="user-list">
            <?php foreach ($liked_users as $user): ?>
                <div class="flex">
                    <div class="likeicom">
                        <img src="../user_image/main/<?php echo htmlspecialchars($user['icon_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="User Icon">
                    </div>
                    <div class="likename">
                        <?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($user['age'], ENT_QUOTES, 'UTF-8'); ?>)
                    </div>
                    <div class="actions">
                        <button class="unlike" data-user-id="<?php echo $user['user_id']; ?>">削除</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>友達になりたい人を見つけに行きましょう。<img src="../image/person2.png" width="300" height="300"></p>
        <div class="like">
            <img src="../image/person1.png" width="300" height="300">
        </div>
    <?php endif; ?>
</div>
<div id="liked_by" class="tab-content">
    <?php if (!empty($liked_by_users)): ?>
        <ul class="user-list">
            <?php foreach ($liked_by_users as $user): ?>
                <div class="flex">
                    <div class="likeicom">
                        <img src="../user_image/main/<?php echo htmlspecialchars($user['icon_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="User Icon">
                    </div>
                    <div class="likename">
                        <?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($user['age'], ENT_QUOTES, 'UTF-8'); ?>)
                    </div>
                    <div class="actions">
                        <button class="unlike" data-user-id="<?php echo $user['user_id']; ?>">削除</button>
                        <button class="like" data-user-id="<?php echo $user['user_id']; ?>">いいね</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>いいねをもらった人はいません。<img src="../image/person1.png" width="300" height="300"></p>
    <?php endif; ?>
</div>
</div>

<script src="../likes/javascript/likes.js"></script>

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
</script>
</body>
</html>
