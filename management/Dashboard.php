<?php require '../m_header.php';?>
    <link rel="stylesheet" href="css/Dashboard.css">
    <title>Dashboard</title>
</head>

<body>
    <?php require '../m_menu/m_menu.php';?>
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

                } catch (PDOException $e) {
                    die('データベースエラー: ' . $e->getMessage());
                }
            ?>

                <h1 class="h1">ダッシュボード</h1>

                <p>ユーザー数：<?php echo $user_count; ?></p>

                <div class="dashboard-item1">
                <p class="m-boy">男性：<?php echo $gender_counts['男性']; ?></p>
                <p class="m-girl">女性：<?php echo $gender_counts['女性']; ?></p>
                <p class="m-others">その他：<?php echo $gender_counts['その他']; ?></p>
                </div>

                <a href="user_ichiran.php">ユーザー一覧へ</a>

                <div class="dashboard-item">
                    <p>通報数：<?php echo $report_count; ?></p>
                    <a href="tuuhou_ichiran.php">通報一覧へ</a>
                </div>

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
