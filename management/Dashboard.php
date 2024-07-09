<?php require '../m_header.php'; ?>
<link rel="stylesheet" href="css/Dashboard.css">
<title>Dashboard</title>
</head>

<body>
    <?php require '../m_menu/m_menu.php'; ?>
    <div class="main">
        <?php
        // データベース接続
        $pdo = new PDO($connect, USER, PASS);
        try {
            // ユーザー数を取得
            $user_count_sql = "SELECT COUNT(*) as count FROM user";
            $user_stmt = $pdo->query($user_count_sql);
            $user_count = $user_stmt->fetchColumn();

            // 性別ごとのユーザー数を取得
            $gender_count_sql = "SELECT g.gender_name AS gender, COUNT(*) as count FROM profile p
                                INNER JOIN gender g ON p.gender_id = g.gender_id
                                GROUP BY p.gender_id";
            $gender_stmt = $pdo->query($gender_count_sql);

            $gender_counts = [
                '男性' => 0,
                '女性' => 0,
                'その他' => 0
            ];

            while ($row = $gender_stmt->fetch(PDO::FETCH_ASSOC)) {
                if (isset($gender_counts[$row['gender']])) {
                    $gender_counts[$row['gender']] = $row['count'];
                }
            }

            // 通報数を取得
            $report_count_sql = "SELECT COUNT(*) as count FROM report";
            $report_stmt = $pdo->query($report_count_sql);
            $report_count = $report_stmt->fetchColumn();

            // ブロック数を取得
            $block_count_sql = "SELECT COUNT(*) as count FROM block";
            $block_stmt = $pdo->query($block_count_sql);
            $block_count = $block_stmt->fetchColumn();

            // カテゴリー別の通報数を取得
            $category_counts = [];
            $category_count_sql = "SELECT category, COUNT(*) as count FROM report GROUP BY category";
            $category_stmt = $pdo->query($category_count_sql);
            while ($row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
                $category_counts[$row['category']] = $row['count'];
            }

        } catch (PDOException $e) {
            die('データベースエラー: ' . $e->getMessage());
        }
        ?>

        <h1 class="h1">ダッシュボード</h1>

        <p>ユーザー数：<?php echo $user_count; ?></p>

        <div class="dash1">
            <div class="dashboard-item1">
                <p class="m-boy">男性<br><?php echo $gender_counts['男性']; ?>人</p>
                <p class="m-girl">女性<br><?php echo $gender_counts['女性']; ?>人</p>
                <p class="m-others">その他<br><?php echo $gender_counts['その他']; ?>人</p>
            </div>
            <div class="itiran1">
                <a href="user_ichiran.php" class="itiranGo">ユーザー一覧へ</a>
            </div>
        </div>

        <div class="dashboard-item">
            <p>通報数件：<?php echo $report_count; ?></p>
        </div>
            <div class="dashboard-item2">
                <?php foreach ($category_counts as $category => $count) : ?>
                    <li><?php echo htmlspecialchars($category); ?><?php echo $count; ?>件</li>
                <?php endforeach; ?>
            </div>
        <a href="tuuhou_ichiran.php" class="itiranGo1">通報一覧へ</a>

                <div class="dashboard-item">
                    <p>ブロック数：<?php echo $block_count; ?></p>
                </div>
    </div>
</body>

</html>

<?php
// データベース接続解除
$pdo = null;
?>
