<?php require '../header.php'; ?>
<title>Match Result</title>
</head>
<body>
<?php require '../menu/menu.php'; ?>
<div class="main">
    <h1>マッチング結果</h1>
    <?php
    session_start();
    if (isset($_SESSION['match_message'])) {
        echo '<p>' . htmlspecialchars($_SESSION['match_message'], ENT_QUOTES, 'UTF-8') . '</p>';
        unset($_SESSION['match_message']); // メッセージを表示したらセッションから削除
    } else {
        echo '<p>マッチング結果がありません。</p>';
    }
    ?>
    <a href="../likes/likes.php">戻る</a>
</div>
</body>
</html>
