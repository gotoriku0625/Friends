<?php
require '../db-connect.php';
$pdo = new PDO($connect, USER, PASS);

// データベースからデータを取得
$sql = "SELECT hobby_name FROM hobby"; 
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll();

// 検索結果を格納する変数を初期化
$results = [];

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] == 'GET' && (isset($_GET['age']) || isset($_GET['residence']) || isset($_GET['gender']) || isset($_GET['school']))) {
    $age = isset($_GET['age']) ? (int)$_GET['age'] : null;
    $residence = isset($_GET['residence']) ? $_GET['residence'] : null;
    $gender = isset($_GET['gender']) ? $_GET['gender'] : null;
    $school = isset($_GET['school']) ? $_GET['school'] : null;


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

        function setGenderInput() {
            const selectBox = document.getElementById('preset-queries-gender');
            const genderInput = document.getElementById('gender');
            genderInput.value = selectBox.value;
        }

        function setResidenceInput() {
            const selectBox = document.getElementById('preset-queries-residence');
            const residenceInput = document.getElementById('residence');
            residenceInput.value = selectBox.value;
        }

        function setSchoolInput() {
            const selectBox = document.getElementById('preset-queries-school');
            const schoolInput = document.getElementById('school');
            schoolInput.value = selectBox.value;
        }
    </script>
</head>
<body>
    <h1>ユーザー検索</h1>
    <form action="result.php" method="GET">
        <label for="preset-queries-age">年齢:</label>
        <select id="preset-queries-age" onchange="setAgeInput()">
            <option value="">選択してください</option>
            <?php for ($i = 18; $i <= 100; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo (isset($_GET['age']) && $_GET['age'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br>
        <label for="gender">性別:</label>
        <select name="gender" id="gender">
            <option value="">選択してください</option>
            <option value="男性" <?php echo (isset($_GET['gender']) && $_GET['gender'] == '男性') ? 'selected' : ''; ?>>男性</option>
            <option value="女性" <?php echo (isset($_GET['gender']) && $_GET['gender'] == '女性') ? 'selected' : ''; ?>>女性</option>
            <option value="その他" <?php echo (isset($_GET['gender']) && $_GET['gender'] == '女性') ? 'selected' : ''; ?>>その他</option>
        </select><br>
        <label for="preset-queries-residence">現住居:</label>
        <select id="preset-queries-residence" onchange="setResidenceInput()">
            <option value="">選択してください</option>
            <option value="東京" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '東京') ? 'selected' : ''; ?>>東京</option>
            <option value="大阪" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '大阪') ? 'selected' : ''; ?>>大阪</option>
            <option value="福岡" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '福岡') ? 'selected' : ''; ?>>福岡</option>
        </select><br>
        <label for="preset-queries-residence">学校名:</label>
        <select id="preset-queries-school" onchange="setschoolInput()">
            <option value="">選択してください</option>
            <option value="麻生情報ビジネス専門学校 福岡校" <?php echo (isset($_GET['school']) && $_GET['school'] == '麻生情報ビジネス専門学校 福岡校') ? 'selected' : ''; ?>>麻生情報ビジネス専門学校 福岡校</option>
            <option value="麻生外語観光＆ブライダル専門学校" <?php echo (isset($_GET['school']) && $_GET['school'] == '麻生外語観光＆ブライダル専門学校') ? 'selected' : ''; ?>>麻生外語観光＆ブライダル専門学校</option>
            <option value="麻生医療福祉＆保育専門学校 福岡校" <?php echo (isset($_GET['school']) && $_GET['school'] == '麻生医療福祉＆保育専門学校 福岡校') ? 'selected' : ''; ?>>麻生医療福祉＆保育専門学校 福岡校</option>
            <option value="麻生建築＆デザイン専門学校" <?php echo (isset($_GET['school']) && $_GET['school'] == '麻生建築＆デザイン専門学校') ? 'selected' : ''; ?>>麻生建築＆デザイン専門学校</option>
            <option value="麻生公務員専門学校 福岡校" <?php echo (isset($_GET['school']) && $_GET['school'] == '麻生公務員専門学校 福岡校') ? 'selected' : ''; ?>>麻生公務員専門学校 福岡校</option>
            <option value="ASOポップカルチャー専門学校" <?php echo (isset($_GET['school']) && $_GET['school'] == 'ASOポップカルチャー専門学校') ? 'selected' : ''; ?>>ASOポップカルチャー専門学校</option>
            <option value="麻生美容専門学校 福岡校" <?php echo (isset($_GET['school']) && $_GET['school'] == '麻生美容専門学校 福岡校') ? 'selected' : ''; ?>>麻生美容専門学校 福岡校</option>
            <option value="専門学校 麻生リハビリテーション大学" <?php echo (isset($_GET['school']) && $_GET['school'] == '専門学校 麻生リハビリテーション大学') ? 'selected' : ''; ?>>専門学校 麻生リハビリテーション大学</option>
            <option value="専門学校 麻生工科自動車大学校" <?php echo (isset($_GET['school']) && $_GET['school'] == '専門学校 麻生工科自動車大学校') ? 'selected' : ''; ?>>専門学校 麻生工科自動車大学校</option>
            <option value="麻生情報ビジネス専門学校 北九州校" <?php echo (isset($_GET['school']) && $_GET['school'] == '麻生情報ビジネス専門学校 北九州校') ? 'selected' : ''; ?>>麻生情報ビジネス専門学校 北九州校</option>
            <option value="麻生公務員専門学校 北九州校" <?php echo (isset($_GET['school']) && $_GET['school'] == '麻生公務員専門学校 北九州校') ? 'selected' : ''; ?>>麻生公務員専門学校 北九州校</option>
            <option value="専門学校 麻生看護大学校" <?php echo (isset($_GET['school']) && $_GET['school'] == '専門学校 麻生看護大学校') ? 'selected' : ''; ?>>専門学校 麻生看護大学校</option>
            <option value="ASO高等部" <?php echo (isset($_GET['school']) && $_GET['school'] == 'ASO高等部') ? 'selected' : ''; ?>>ASO高等部</option>

        </select><br>
        <label for="dropdown">趣味</label>
        <select name="selected_data" id="dropdown">
            <?php foreach ($data as $row): ?>
                <option value="<?php echo htmlspecialchars($row['hobby_name']); ?>">
                    <?php echo htmlspecialchars($row['hobby_name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="検索">
    </form>
    <h1>検索結果</h1>
    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $user): ?>
                <li><?php echo htmlspecialchars($user['name']); ?> - <?php echo htmlspecialchars($user['age']); ?> - <?php echo htmlspecialchars($user['residence']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'GET'): // フォームが送信されたが結果がない場合のみメッセージを表示 ?>
            <p>検索結果がありません。</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>