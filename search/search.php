<?php
require '../header.php'; // これは必要に応じて適切なパスに修正してください
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー検索</title>
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

    <div class="main">
        <h1 class="h1-search">ユーザー検索</h1>
            <hr>
        
        <form action="result.php" method="GET">
            <!-- ユーザー名検索フォーム -->
            <div class="nickname">
                <!-- <label for="nickname">ユーザー名:</label><br> -->
                <input type="text" id="nickname" name="nickname" placeholder="ユーザー名"><input type="submit" class="search-button" value="">
            </div>
        <div class="container">
            <div class="tab">
                <div class="tab-item" data-tab="age">年齢</div>
                <div class="tab-item" data-tab="gender">性別</div>
                <div class="tab-item" data-tab="residence">現住居</div>
                <div class="tab-item" data-tab="school">学校名</div>
                <div class="tab-item" data-tab="hobby">趣味</div>
            </div>

            <!-- 各タブの内容 -->
            <div id="age" class="tab-content">
                <!-- <label for="age">年齢:</label><br> -->
                <input type="checkbox" id="age_18" name="age[]" value="18">
                <label for="age_18" class="search-age">18歳</label><br>
                <input type="checkbox" id="age_19" name="age[]" value="19">
                <label for="age_19" class="search-age">19歳</label><br>
                <input type="checkbox" id="age_20" name="age[]" value="20">
                <label for="age_20" class="search-age">20歳</label><br>
                <input type="checkbox" id="age_21" name="age[]" value="21">
                <label for="age_21" class="search-age">21歳</label><br>
                <input type="checkbox" id="age_22" name="age[]" value="22">
                <label for="age_22" class="search-age">22歳</label><br>
                <input type="checkbox" id="age_22_plus" name="age[]" value="22_plus">
                <label for="age_22_plus" class="search-age">23歳~29歳</label><br>
                <input type="checkbox" id="age_30s" name="age[]" value="30s">
                <label for="age_30s" class="search-age">30代</label><br>
                <input type="checkbox" id="age_40s" name="age[]" value="40s">
                <label for="age_40s" class="search-age">40代</label><br>
                <input type="checkbox" id="age_50s" name="age[]" value="50s">
                <label for="age_50s" class="search-age">50代</label><br>
                <input type="checkbox" id="age_60s" name="age[]" value="60s">
                <label for="age_60s" class="search-age">60代</label><br>
                <input type="checkbox" id="age_70s" name="age[]" value="70s">
                <label for="age_70s" class="search-age">70代</label><br>
            </div>

            <div id="gender" class="tab-content">
                <!-- <label for="dropdown">性別:</label><br> -->
                <?php foreach ($dataGender as $row): ?>
                    <input type="checkbox" id="gender_<?php echo $row['gender_id']; ?>" name="selected_gender_id[]" value="<?php echo htmlspecialchars($row['gender_id']); ?>">
                    <label for="gender_<?php echo $row['gender_id']; ?>"><?php echo htmlspecialchars($row['gender_name']); ?></label><br>
                <?php endforeach; ?>
            </div>

            <div id="residence" class="tab-content">
                <!-- <label for="dropdown">現住居:</label><br> -->
                <?php foreach ($dataResidence as $row): ?>
                    <input type="checkbox" id="residence_<?php echo $row['residence_id']; ?>" name="selected_residence_id[]" value="<?php echo htmlspecialchars($row['residence_id']); ?>">
                    <label for="residence_<?php echo $row['residence_id']; ?>"><?php echo htmlspecialchars($row['residence_name']); ?></label><br>
                <?php endforeach; ?>
            </div>

            <div id="school" class="tab-content">
                <!-- <label for="dropdown">学校名:</label><br> -->
                <?php foreach ($dataSchool as $row): ?>
                    <input type="checkbox" id="school_<?php echo $row['school_id']; ?>" name="selected_school_id[]" value="<?php echo htmlspecialchars($row['school_id']); ?>">
                    <label for="school_<?php echo $row['school_id']; ?>"><?php echo htmlspecialchars($row['school_name']); ?></label><br>
                <?php endforeach; ?>
            </div>

            <div id="hobby" class="tab-content">
                <!-- <label for="dropdown">趣味:</label><br> -->
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
    </div>
</body>
</html>
