<?php require '../header.php';?>
    <link rel="stylesheet" href="../search.css">
    <title>検索</title>
</head>

<body>
<?php require '../menu/menu.php';?>

<?php $pdo = new PDO($connect, USER, PASS);

// データベースから趣味データを取得
$sql = "SELECT hobby_id, hobby_name FROM hobby";
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll();

// 学校名と都道府県のリスト
$schools = [
    "麻生情報ビジネス専門学校 福岡校",
    "麻生外語観光＆ブライダル専門学校",
    "麻生医療福祉＆保育専門学校 福岡校",
    "麻生建築＆デザイン専門学校",
    "麻生公務員専門学校 福岡校",
    "ASOポップカルチャー専門学校",
    "麻生美容専門学校 福岡校",
    "専門学校 麻生リハビリテーション大学",
    "専門学校 麻生工科自動車大学校",
    "麻生情報ビジネス専門学校 北九州校",
    "麻生公務員専門学校 北九州校",
    "専門学校 麻生看護大学校",
    "ASO高等部"
];

$prefectures = [
    "北海道", "青森県", "岩手県", "宮城県", "秋田県", "山形県", "福島県", "茨城県", "栃木県", "群馬県", "埼玉県", 
    "千葉県", "東京都", "神奈川県", "新潟県", "富山県", "石川県", "福井県", "山梨県", "長野県", "岐阜県", "静岡県", 
    "愛知県", "三重県", "滋賀県", "京都府", "大阪府", "兵庫県", "奈良県", "和歌山県", "鳥取県", "島根県", "岡山県", 
    "広島県", "山口県", "徳島県", "香川県", "愛媛県", "高知県", "福岡県", "佐賀県", "長崎県", "熊本県", "大分県", 
    "宮崎県", "鹿児島県", "沖縄県"
];
?>
    <div class="container">
        <h1>ユーザー検索</h1>

        <form action="result.php" method="GET">
            <!-- ユーザー名検索フォーム -->
            <div>
                <label for="nickname">ユーザー名:</label><br>
                <input type="text" id="nickname" name="nickname"><input type="submit" class="search-button" value="">
            </div>

            <div class="tab">
                <div class="tab-item" data-tab="age">年齢</div>
                <div class="tab-item" data-tab="gender">性別</div>
                <div class="tab-item" data-tab="residence">現住居</div>
                <div class="tab-item" data-tab="school">学校名</div>
                <div class="tab-item" data-tab="hobby">趣味</div>
            </div>

            <!-- 各タブの内容 -->
            <div id="age" class="tab-content">
                <label for="age">年齢:</label><br>
                <?php for ($i = 18; $i <= 100; $i++): ?>
                    <input type="checkbox" id="age_<?php echo $i; ?>" name="age[]" value="<?php echo $i; ?>">
                    <label for="age_<?php echo $i; ?>"><?php echo $i; ?></label><br>
                <?php endfor; ?>
            </div>

            <div id="gender" class="tab-content">
                <label for="gender">性別:</label><br>
                <input type="checkbox" id="male" name="gender[]" value="男性">
                <label for="male">男性</label><br>
                <input type="checkbox" id="female" name="gender[]" value="女性">
                <label for="female">女性</label><br>
                <input type="checkbox" id="other" name="gender[]" value="その他">
                <label for="other">その他</label><br>
            </div>

            <div id="residence" class="tab-content">
                <label for="residence">現住居:</label><br>
                <?php foreach ($prefectures as $prefecture): ?>
                    <input type="checkbox" id="residence_<?php echo $prefecture; ?>" name="residence[]" value="<?php echo $prefecture; ?>">
                    <label for="residence_<?php echo $prefecture; ?>"><?php echo $prefecture; ?></label><br>
                <?php endforeach; ?>
            </div>

            <div id="school" class="tab-content">
                <label for="school">学校名:</label><br>
                <?php foreach ($schools as $school): ?>
                    <input type="checkbox" id="school_<?php echo htmlspecialchars($school); ?>" name="school[]" value="<?php echo htmlspecialchars($school); ?>">
                    <label for="school_<?php echo htmlspecialchars($school); ?>"><?php echo htmlspecialchars($school); ?></label><br>
                <?php endforeach; ?>
            </div>

            <div id="hobby" class="tab-content">
                <label for="dropdown">趣味:</label><br>
                <?php foreach ($data as $row): ?>
                    <input type="checkbox" id="hobby_<?php echo $row['hobby_id']; ?>" name="selected_hobby_id[]" value="<?php echo htmlspecialchars($row['hobby_id']); ?>">
                    <label for="hobby_<?php echo $row['hobby_id']; ?>"><?php echo htmlspecialchars($row['hobby_name']); ?></label><br>
                <?php endforeach; ?>
            </div>

           
        </form>
    </div>

    <script>
        let lastActiveTab = null; // 最後にアクティブだったタブを保持する変数

        document.querySelectorAll('.tab-item').forEach(item => {
            item.addEventListener('click', event => {
                // クリックされたタブがアクティブであれば非アクティブにする
                if (item.classList.contains('is-active')) {
                    item.classList.remove('is-active');
                    document.getElementById(item.getAttribute('data-tab')).classList.remove('is-active');
                    lastActiveTab = null; // 最後のアクティブタブをリセット
                } else {
                    // 最後にアクティブだったタブがあれば、それを非アクティブにする
                    if (lastActiveTab) {
                        lastActiveTab.classList.remove('is-active');
                        document.getElementById(lastActiveTab.getAttribute('data-tab')).classList.remove('is-active');
                    }
                    
                    // クリックされたタブをアクティブにする
                    item.classList.add('is-active');
                    
                    const tabName = event.target.getAttribute('data-tab');
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('is-active');
                    });
                    document.getElementById(tabName).classList.add('is-active');

                    // 最後にアクティブだったタブを更新
                    lastActiveTab = item;
                }
            });
        });
    </script>
    </div>
</body>
</html>
