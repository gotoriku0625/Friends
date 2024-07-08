<?php require '../header.php'; ?>
<link rel="stylesheet" href="../likes/likes.css">
<title>likes</title>
</head>
<?php
$pdo = new PDO($connect, USER, PASS);
$logged_in_user_id = $_SESSION['user']['id']; // ログインユーザーIDをセッションから取得

// いいねした人の一覧を取得
$sql_liked = "SELECT user.user_id, user.user_name, profile.icon_image, profile.age, gender.gender_name, profile.profile_id
              FROM likes 
              JOIN user ON likes.liked_user_id = user.user_id 
              JOIN profile ON user.user_id = profile.user_id
              JOIN gender ON profile.gender_id = gender.gender_id
              WHERE likes.likes_user_id = ?";
$stmt_liked = $pdo->prepare($sql_liked);
$stmt_liked->bindValue(1, $logged_in_user_id, PDO::PARAM_INT);
$stmt_liked->execute();
$liked_users = $stmt_liked->fetchAll(PDO::FETCH_ASSOC);
$stmt_liked->closeCursor();

// いいねされた人の一覧を取得
$sql_liked_by = "SELECT user.user_id, user.user_name, profile.icon_image, profile.age, gender.gender_name, profile.profile_id
                 FROM likes 
                 JOIN user ON likes.likes_user_id = user.user_id 
                 JOIN profile ON user.user_id = profile.user_id
                 JOIN gender ON profile.gender_id = gender.gender_id
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
            <div class="recommendation2">
                <?php foreach ($liked_users as $user): ?>
                    <div class="user-set2">
                        <?php if($user['gender_name'] === '男性'): ?>
                            <div class="frame-blue2">
                        <?php elseif($user['gender_name'] === '女性'): ?>
                            <div class="frame-pink2">
                        <?php else: ?>
                            <div class="frame-gray2">
                        <?php endif; ?>
                                <a href="../profile/profile-like.php?user_id=<?php echo $user['user_id']; ?>">
                                    <img src="../user_image/main/<?php echo htmlspecialchars($user['icon_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="User Icon" class="standard-icon">
                                </a>
                            </div>
                        <div class="nick_name2">
                            <?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($user['age'], ENT_QUOTES, 'UTF-8'); ?>)
                        </div>
                        <div class="actions">
                            <form action="../likes/unlike.php" method="post">
                                <input type="hidden" name="liked_user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="unlike"><img src="../image/bat.png" class="bat"></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>友達になりたい人を見つけに行きましょう。<img src="../image/person2.png" width="300" height="300"></p>
        <?php endif; ?>
    </div>
    <div id="liked_by" class="tab-content">
        <?php if (!empty($liked_by_users)): ?>
            <div class="recommendation2">
                <?php foreach ($liked_by_users as $user): ?>
                    <div class="user-set2">
                        <?php if($user['gender_name'] === '男性'): ?>
                            <div class="frame-blue2">
                        <?php elseif($user['gender_name'] === '女性'): ?>
                            <div class="frame-pink2">
                        <?php else: ?>
                            <div class="frame-gray2">
                        <?php endif; ?>
                                <a href="../profile/profile-match.php?user_id=<?php echo $user['user_id']; ?>">
                                    <img src="../user_image/main/<?php echo htmlspecialchars($user['icon_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="User Icon" class="standard-icon">
                                </a>
                            </div>
                        <div class="nick_name2">
                            <?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($user['age'], ENT_QUOTES, 'UTF-8'); ?>)
                        </div>
                        <div class="actions">
                            <form action="../matchs/match.php" method="post">
                                <input type="hidden" name="liked_user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="like"><img src="../image/you.png" class="icon"></button>
                            </form>
                            <form action="../likes/unlike.php" method="post">
                                <input type="hidden" name="liked_user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="unlike"><img src="../image/bat.png" class="bat"></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>友達になりたい人を見つけに行きましょう。<img src="../image/person2.png" width="300" height="300"></p>
        <?php endif; ?>
    </div>
</div>

<script src="../menu/script.js"></script>
<script>
    function showTab(tabId) {
        var tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });
        document.getElementById(tabId).classList.add('active');

        var tabButtons = document.querySelectorAll('.tab');
        tabButtons.forEach(function(button) {
            button.classList.remove('active');
        });
        document.querySelector('.tab[onclick="showTab(\'' + tabId + '\')"]').classList.add('active');
    }

    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
