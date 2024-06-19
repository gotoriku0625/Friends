<?php
require '../header.php'; // ヘッダーファイルの読み込み
try {
    $pdo = new PDO($dsn, USER, PASS);
    // プロフィール情報を取得するクエリの準備と実行
    $stmt = $pdo->prepare('SELECT * FROM profile WHERE profile_id = ?');
    $stmt->execute([1]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    // HTML出力
    ?>
 </head>
    <body>
        <h1>プロフィール詳細</h1>
        <div class="container">
            <div class="profile">
                <h2><?php echo htmlspecialchars($profile['username']); ?></h2>
                <p>年齢: <?php echo htmlspecialchars($profile['age']); ?></p>
                <p>性別: <?php echo htmlspecialchars($profile['gender']); ?></p>
                <!-- 必要に応じて他のプロフィール情報を表示 -->
            </div>
        </div>
    </body>
    </html>
    <?php

} catch (PDOException $e) {
    // データベースエラー時の処理
    die("データベースエラー: " . $e->getMessage());
}
?>
