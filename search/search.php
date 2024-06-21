<?php
require '../header.php'; // これは必要に応じて適切なパスに修正してください
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー検索</title>
    <link rel="stylesheet" href="./top.css">
    <link rel="stylesheet" href="../menu/menu.css">
    <link rel="stylesheet" href="search.css">
</head>
<body>
    <?php require '../menu/menu.php'; ?>

    <?php
    // データベース接続設定（適切に修正してください）
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 各データを取得するSQLクエリを実行
    $sqlHobby = "SELECT hobby_id, hobby_name FROM hobby";
    $stmtHobby = $pdo->query($sqlHobby);
    $dataHobby = $stmtHobby->fetchAll();

    $sqlGender = "SELECT gender_id, gender_name FROM gender";
    $stmtGender = $pdo->query($sqlGender);
    $dataGender = $stmtGender->fetchAll();

    $sqlResidence = "SELECT residence_id, residence_name FROM residence";
    $stmtResidence = $pdo->query($sqlResidence);
    $dataResidence = $stmtResidence->fetchAll();

    $sqlSchool = "SELECT school_id, school_name FROM school";
    $stmtSchool = $pdo->query($sqlSchool);
    $dataSchool = $stmtSchool->fetchAll();
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
                <label for="dropdown">性別:</label><br>
                <?php foreach ($dataGender as $row): ?>
                    <input type="checkbox" id="gender_<?php echo $row['gender_id']; ?>" name="selected_gender_id[]" value="<?php echo htmlspecialchars($row['gender_id']); ?>">
                    <label for="gender_<?php echo $row['gender_id']; ?>"><?php echo htmlspecialchars($row['gender_name']); ?></label><br>
                <?php endforeach; ?>
            </div>

            <div id="residence" class="tab-content">
                <label for="dropdown">現住居:</label><br>
                <?php foreach ($dataResidence as $row): ?>
                    <input type="checkbox" id="residence_<?php echo $row['residence_id']; ?>" name="selected_residence_id[]" value="<?php echo htmlspecialchars($row['residence_id']); ?>">
                    <label for="residence_<?php echo $row['residence_id']; ?>"><?php echo htmlspecialchars($row['residence_name']); ?></label><br>
                <?php endforeach; ?>
            </div>

            <div id="school" class="tab-content">
                <label for="dropdown">学校名:</label><br>
                <?php foreach ($dataSchool as $row): ?>
                    <input type="checkbox" id="school_<?php echo $row['school_id']; ?>" name="selected_school_id[]" value="<?php echo htmlspecialchars($row['school_id']); ?>">
                    <label for="school_<?php echo $row['school_id']; ?>"><?php echo htmlspecialchars($row['school_name']); ?></label><br>
                <?php endforeach; ?>
            </div>

            <div id="hobby" class="tab-content">
                <label for="dropdown">趣味:</label><br>
                <?php foreach ($dataHobby as $row): ?>
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
</body>
</html>
