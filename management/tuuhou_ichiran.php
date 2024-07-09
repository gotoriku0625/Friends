<?php
require '../m_header.php';
$pdo = new PDO($connect, USER, PASS);

// 通報数を取得するSQLクエリ
$count_sql = "SELECT COUNT(*) as report_count FROM report";
$count_stmt = $pdo->query($count_sql);
$count_result = $count_stmt->fetch(PDO::FETCH_ASSOC);
$report_count = $count_result['report_count'];

// データを取得するSQLクエリ
$sql = "
SELECT 
    r.report_id, 
    u1.user_name AS reporter_name, 
    u2.user_name AS reported_name, 
    r.content 
FROM 
    report r
JOIN 
    user u1 ON r.reporter_id = u1.user_id
JOIN 
    user u2 ON r.reported_id = u2.user_id
";

// クエリを実行してデータを取得
$stmt = $pdo->query($sql);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
   <?php require '../m_menu/m_menu.php';?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="css/tuuhou_ichiran.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>通報一覧</title>
</head>
<body>
    <div class="main">
    <h1>通報一覧</h1>
    <div class="count">
    <p>通報数: <?php echo htmlspecialchars($report_count, ENT_QUOTES, 'UTF-8'); ?></p>
</div>
    <table>
        <thead>
            <tr>
                <th>通報者</th><th>相手</th><th>通報内容</th><th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['reporter_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($report['reported_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($report['content'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="../talk/talk_top.php">トークへ</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            </div>
</body>
</html>
