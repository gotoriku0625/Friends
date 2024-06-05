<?php
require '../db-connect.php';
$pdo = new PDO($connect, USER, PASS);

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // 選択された条件を取得
    $nick_name = isset($_GET['nickname']) ? $_GET['nickname'] : null;
    $age = isset($_GET['age']) ? $_GET['age'] : null;
    $residence = isset($_GET['residence']) ? $_GET['residence'] : null;
    $gender = isset($_GET['gender']) ? $_GET['gender'] : null;
    $school = isset($_GET['school']) ? $_GET['school'] : null;
    $hobby = isset($_GET['selected_hobby_id']) ? $_GET['selected_hobby_id'] : null;

    // SQLクエリの構築
    $sql = "SELECT * FROM profile WHERE 1=1";
    $params = [];

    if ($nick_name) {
        $sql .= " AND nick_name LIKE :nick_name";
        $params[':nick_name'] = '%' . $nick_name . '%';
    }
    if ($age) {
        $sql .= " AND age IN (".implode(',', array_map('intval', $age)).")";
    }
    if ($gender) {
        $sql .= " AND gender IN ('".implode("','", $gender)."')";
    }
    if ($residence) {
        $sql .= " AND residence IN ('".implode("','", $residence)."')";
    }
    if ($school) {
        $sql .= " AND school IN ('".implode("','", $school)."')";
    }
    if ($hobby) {
        $sql .= " AND hobby_id IN (".implode(',', array_map('intval', $hobby)).")";
    }

    // SQLを実行
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
</head>
<body>
    <h1>検索結果</h1>
    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $profile): ?>
                <li><?php echo htmlspecialchars($profile['nick_name']); ?> - <?php echo htmlspecialchars($profile['age']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>検索結果がありません。</p>
    <?php endif; ?>
    <a href="search.php">検索フォームに戻る</a>
</body>
</html>