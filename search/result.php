<?php
require '../db-connect.php';
$pdo = new PDO($connect, USER, PASS);

// 検索結果を格納する変数を初期化
$results = [];

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['age']) || isset($_GET['residence']) || isset($_GET['gender']) || isset($_GET['school']) || isset($_GET['selected_data']))) {
    $age = isset($_GET['age']) ? (int)$_GET['age'] : null;
    $residence = isset($_GET['residence']) ? $_GET['residence'] : null;
    $gender = isset($_GET['gender']) ? $_GET['gender'] : null;
    $school = isset($_GET['school']) ? $_GET['school'] : null;
    $hobby = isset($_GET['selected_data']) ? $_GET['selected_data'] : null;

    // SQLクエリの構築
    $sql = "SELECT * FROM profile WHERE 1=1";
    $params = [];

    if ($age) {
        $sql .= " AND age = :age";
        $params[':age'] = $age;
    }
    if ($gender) {
        $sql .= " AND gender = :gender";
        $params[':gender'] = $gender;
    }
    if ($residence) {
        $sql .= " AND residence = :residence";
        $params[':residence'] = $residence;
    }
    if ($school) {
        $sql .= " AND school = :school";
        $params[':school'] = $school;
    }
    if ($hobby) {
        $sql .= " AND hobby_id = :hobby";
        $params[':hobby'] = $hobby;
    }

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
        <?php if ($_SERVER['REQUEST_METHOD'] == 'GET'): // フォームが送信されたが結果がない場合のみメッセージを表示 ?>
            <p>検索結果がありません。</p>
        <?php endif; ?>
    <?php endif; ?>
    <a href="search.php">検索フォームに戻る</a>
</body>
</html>