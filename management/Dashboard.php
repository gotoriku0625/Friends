<?php require '../header.php';?>
<!-- ↓ここにＣＳＳを追加↓ -->
<title>Friends Top</title>
</head>

<body>



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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Dashboard.css">
    <title>ダッシュボード</title>
</head>
<body>
<div class="container">
    <h1>ダッシュボード</h1>
    <div class="dashboard-item">
    <p>ユーザー数：<?php echo $user_count; ?></p>
    <p>男性：<?php echo $gender_counts['男性']; ?></p>
    <p>女性：<?php echo $gender_counts['女性']; ?></p>
    <p>その他：<?php echo $gender_counts['その他']; ?></p>
    <a href="user_ichiran.php">ユーザー一覧へ</a>
</div>

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
