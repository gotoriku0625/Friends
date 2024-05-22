<?php
require 'db_connect.php';

// GETパラメータから検索条件を取得
$age = isset($_GET['age']) ? (int)$_GET['age'] : null;
$location = isset($_GET['location']) ? $_GET['location'] : null;

// SQLクエリの構築
$sql = "SELECT * FROM users WHERE 1=1";
$params = [];

if ($age) {
    $sql .= " AND age = :age";
    $params[':age'] = $age;
}

if ($location) {
    $sql .= " AND location LIKE :location";
    $params[':location'] = '%' . $location . '%';
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
</head>
<body>
    <h1>検索結果</h1>
    <?php if (count($results) > 0): ?>
        <ul>
            <?php foreach ($results as $user): ?>
                <li><?php echo htmlspecialchars($user['name']); ?> - <?php echo htmlspecialchars($user['age']); ?> - <?php echo htmlspecialchars($user['location']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>検索結果がありません。</p>
    <?php endif; ?>
    <a href="search_form.html">検索に戻る</a>
</body>
</html>