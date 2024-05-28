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
    <option value="北海道" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '北海道') ? 'selected' : ''; ?>>北海道</option>
    <option value="青森県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '青森県') ? 'selected' : ''; ?>>青森県</option>
    <option value="岩手県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '岩手県') ? 'selected' : ''; ?>>岩手県</option>
    <option value="宮城県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '宮城県') ? 'selected' : ''; ?>>宮城県</option>
    <option value="秋田県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '秋田県') ? 'selected' : ''; ?>>秋田県</option>
    <option value="山形県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '山形県') ? 'selected' : ''; ?>>山形県</option>
    <option value="福島県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '福島県') ? 'selected' : ''; ?>>福島県</option>
    <option value="茨城県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '茨城県') ? 'selected' : ''; ?>>茨城県</option>
    <option value="栃木県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '栃木県') ? 'selected' : ''; ?>>栃木県</option>
    <option value="群馬県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '群馬県') ? 'selected' : ''; ?>>群馬県</option>
    <option value="埼玉県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '埼玉県') ? 'selected' : ''; ?>>埼玉県</option>
    <option value="千葉県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '千葉県') ? 'selected' : ''; ?>>千葉県</option>
    <option value="東京都" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '東京都') ? 'selected' : ''; ?>>東京都</option>
    <option value="神奈川県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '神奈川県') ? 'selected' : ''; ?>>神奈川県</option>
    <option value="新潟県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '新潟県') ? 'selected' : ''; ?>>新潟県</option>
    <option value="富山県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '富山県') ? 'selected' : ''; ?>>富山県</option>
    <option value="石川県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '石川県') ? 'selected' : ''; ?>>石川県</option>
    <option value="福井県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '福井県') ? 'selected' : ''; ?>>福井県</option>
    <option value="山梨県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '山梨県') ? 'selected' : ''; ?>>山梨県</option>
    <option value="長野県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '長野県') ? 'selected' : ''; ?>>長野県</option>
    <option value="岐阜県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '岐阜県') ? 'selected' : ''; ?>>岐阜県</option>
    <option value="静岡県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '静岡県') ? 'selected' : ''; ?>>静岡県</option>
    <option value="愛知県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '愛知県') ? 'selected' : ''; ?>>愛知県</option>
    <option value="三重県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '三重県') ? 'selected' : ''; ?>>三重県</option>
    <option value="滋賀県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '滋賀県') ? 'selected' : ''; ?>>滋賀県</option>
    <option value="京都府" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '京都府') ? 'selected' : ''; ?>>京都府</option>
    <option value="大阪府" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '大阪府') ? 'selected' : ''; ?>>大阪府</option>
    <option value="兵庫県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '兵庫県') ? 'selected' : ''; ?>>兵庫県</option>
    <option value="奈良県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '奈良県') ?'selected' : ''; ?>>奈良県</option>
    <option value="和歌山県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '和歌山県') ? 'selected' : ''; ?>>和歌山県</option>
    <option value="鳥取県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '鳥取県') ? 'selected' : ''; ?>>鳥取県</option>
    <option value="島根県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '島根県') ? 'selected' : ''; ?>>島根県</option>
    <option value="岡山県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '岡山県') ? 'selected' : ''; ?>>岡山県</option>
    <option value="広島県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '広島県') ? 'selected' : ''; ?>>広島県</option>
    <option value="山口県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '山口県') ? 'selected' : ''; ?>>山口県</option>
    <option value="徳島県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '徳島県') ? 'selected' : ''; ?>>徳島県</option>
    <option value="香川県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '香川県') ? 'selected' : ''; ?>>香川県</option>
    <option value="愛媛県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '愛媛県') ? 'selected' : ''; ?>>愛媛県</option>
    <option value="高知県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '高知県') ? 'selected' : ''; ?>>高知県</option>
    <option value="福岡県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '福岡県') ? 'selected' : ''; ?>>福岡県</option>
    <option value="佐賀県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '佐賀県') ? 'selected' : ''; ?>>佐賀県</option>
    <option value="長崎県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '長崎県') ? 'selected' : ''; ?>>長崎県</option>
    <option value="熊本県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '熊本県') ? 'selected' : ''; ?>>熊本県</option>
    <option value="大分県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '大分県') ? 'selected' : ''; ?>>大分県</option>
    <option value="宮崎県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '宮崎県') ? 'selected' : ''; ?>>宮崎県</option>
    <option value="鹿児島県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '鹿児島県') ? 'selected' : ''; ?>>鹿児島県</option>
    <option value="沖縄県" <?php echo (isset($_GET['residence']) && $_GET['residence'] == '沖縄県') ? 'selected' : ''; ?>>沖縄県</option>
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
    <option value="">選択してください</option> <!-- 条件を選ばない選択肢を追加 -->
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