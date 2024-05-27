<?php
    const SERVER = 'mysql301.phy.lolipop.lan';
    const DBNAME = 'LAA1517801-friends';
    const USER = 'LAA1517801';
    const PASS = 'pass0625';
 
    $connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';
?>
<!DOCTYPE html>
<html lang="en">
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
            <p><img src="../menu-image/community-free-icon.png" class="community-free-icon"><a href="../community/community.php">コミュニティ</a></p>
            <p><img src="../menu-image/talk-free-icon.png" class="talk-free-icon"><a href="../talk/talk.php">トーク</a></p>
        </div>
    </div>

    <div class="main">
    <button onclick="location.href='./ilike.php'">いいねした人</button>あなたへいいね
    <hr></hr>
  <ul>
    <?php while ($row = $result_liked_by->fetch_assoc()) { ?>
      <li><?php echo htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['age']) . ") - " . htmlspecialchars($row['bio']); ?></li>
    <?php } ?>
  </ul>
    </div>
</body>
</html>