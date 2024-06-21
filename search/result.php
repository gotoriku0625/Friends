<?php require '../header.php';?>
<link rel="stylesheet" href="./top.css">
<link rel="stylesheet" href="../menu/menu.css">
<link rel="stylesheet" href="result.css">
<title>result</title>
</head>

<body>
<?php require '../menu/menu.html'; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
</head>
<body>
    <div class="menu">
       
    </div>
    
    <div class="main">
        <h1>検索結果</h1>
        <?php
        $pdo = new PDO($connect, USER, PASS);

        // フォームが送信された場合の処理
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // 選択された条件を取得
            $user_name = isset($_GET['nickname']) ? $_GET['nickname'] : null;
            $age = isset($_GET['age']) ? $_GET['age'] : null;
            $residence = isset($_GET['residence']) ? $_GET['residence'] : null;
            $gender = isset($_GET['gender']) ? $_GET['gender'] : null;
            $school = isset($_GET['school']) ? $_GET['school'] : null;
            $hobby = isset($_GET['selected_hobby_id']) ? $_GET['selected_hobby_id'] : null;

            // SQLクエリの構築
            $sql = "SELECT profile.*, user.user_name FROM profile
                    JOIN user ON profile.user_id = user.user_id
                    WHERE 1=1";
            $params = [];

            if ($user_name) {
                $sql .= " AND user.user_name LIKE :user_name";
                $params[':user_name'] = '%' . $user_name . '%';
            }
            if ($age) {
                $sql .= " AND age IN (" . implode(',', array_map('intval', $age)) . ")";
            }
            if ($gender) {
                $sql .= " AND gender IN ('" . implode("','", $gender) . "')";
            }
            if ($residence) {
                $sql .= " AND residence IN ('" . implode("','", $residence) . "')";
            }
            if ($school) {
                $sql .= " AND school IN ('" . implode("','", $school) . "')";
            }
            if ($hobby) {
                $sql .= " AND hobby_id IN (" . implode(',', array_map('intval', $hobby)) . ")";
            }

            $sql .= " ORDER BY age ASC";

            // SQLを実行
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll();
        }
        ?>

        <?php if (!empty($results)): ?>
            <ul>
                <?php foreach ($results as $profile): ?>
                    <li>
                        <a href="../profile/profile-user.html">
                            <img src="<?php echo htmlspecialchars($profile['icon_image']); ?>" alt="icon" class="icon <?php echo htmlspecialchars($profile['gender_id']); ?>">
                            <?php echo htmlspecialchars($profile['user_name']); ?><?php echo " (" . htmlspecialchars($profile['age']) . ")"; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>検索結果がありません。</p>
        <?php endif; ?>
        <a href="search.php" class="center">検索フォームに戻る</a>
    </div>
</body>
</html>
