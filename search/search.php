<?php
require 'db_connect.php';

// データベースからデータを取得
$sql = "SELECT hobby_name FROM hobby"; 
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll();

// 検索結果を格納する変数を初期化
$results = [];

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['age']) || isset($_GET['location']))) {
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
        $sql .= " AND location = :location";
        $params[':location'] = $location;
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
    <title>ユーザー検索</title>
    <script>
        function setAgeInput() {
            const selectBox = document.getElementById('preset-queries-age');
            const ageInput = document.getElementById('age');
            ageInput.value = selectBox.value;
        }

        function setLocationInput() {
            const selectBox = document.getElementById('preset-queries-location');
            const locationInput = document.getElementById('location');
            locationInput.value = selectBox.value;
        }
    </script>
</head>
<body>
    <h1>ユーザー検索</h1>
    <form action="search.php" method="GET">
        <label for="preset-queries-age">年齢:</label>
        <select id="preset-queries-age" onchange="setAgeInput()">
            <option value="">選択してください</option>
            <?php for ($i = 18; $i <= 100; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo (isset($_GET['age']) && $_GET['age'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br>

        <label for="preset-queries-location">現住居:</label>
        <select id="preset-queries-location" onchange="setLocationInput()">
            <option value="">選択してください</option>
            <option value="東京" <?php echo (isset($_GET['location']) && $_GET['location'] == '東京') ? 'selected' : ''; ?>>東京</option>
            <option value="大阪" <?php echo (isset($_GET['location']) && $_GET['location'] == '大阪') ? 'selected' : ''; ?>>大阪</option>
            <option value="福岡" <?php echo (isset($_GET['location']) && $_GET['location'] == '福岡') ? 'selected' : ''; ?>>福岡</option>
        </select><br>
        <label for="dropdown">趣味</label>
        <select name="selected_data" id="dropdown">
            <?php foreach ($data as $row): ?>
                <option value="<?php echo htmlspecialchars($row['hobby_name']); ?>"></option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" value="検索">
    </form>
    <h1>検索結果</h1>
    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $user): ?>
                <li><?php echo htmlspecialchars($user['name']); ?> - <?php echo htmlspecialchars($user['age']); ?> - <?php echo htmlspecialchars($user['location']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'GET'): // フォームが送信されたが結果がない場合のみメッセージを表示 ?>
            <p>検索結果がありません。</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>