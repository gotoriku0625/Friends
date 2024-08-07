<?php require '../header.php'; ?>
<?php require '../menu/menu.php'; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../menu/menu.css">
    <link rel="stylesheet" href="result.css">
    <title>検索結果</title>
</head>
<body>

<div class="main">
    <?php
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // フォームが送信された場合の処理
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // 選択された条件を取得
        $user_name = isset($_GET['nickname']) ? $_GET['nickname'] : null;
        $age = isset($_GET['age']) ? $_GET['age'] : null;
        $residence = isset($_GET['selected_residence_id']) ? $_GET['selected_residence_id'] : null;
        $gender = isset($_GET['selected_gender_id']) ? $_GET['selected_gender_id'] : null;
        $school = isset($_GET['selected_school_id']) ? $_GET['selected_school_id'] : null;
        $hobby = isset($_GET['selected_hobby_id']) ? $_GET['selected_hobby_id'] : null;

        if (isset($_SESSION['user']['id'])) {
            $loggedInUserId = $_SESSION['user']['id'];
        
            $sql = "SELECT profile.*, user.user_name, gender.gender_name FROM profile
                    JOIN user ON profile.user_id = user.user_id
                    JOIN gender ON profile.gender_id = gender.gender_id
                    WHERE profile.user_id != :loggedInUserId";
        
            $params = [':loggedInUserId' => $loggedInUserId];

            if ($user_name) {
                $sql .= " AND user.user_name LIKE :user_name";
                $params[':user_name'] = '%' . $user_name . '%';
            }

            // 年齢条件
            if ($age && !in_array('all', $age)) {
                $ageConditions = [];
                foreach ($age as $ageGroup) {
                    switch ($ageGroup) {
                        case '18':
                        case '19':
                        case '20':
                        case '21':
                        case '22':
                            $ageConditions[] = "age = " . intval($ageGroup);
                            break;
                        case '22_plus':
                            $ageConditions[] = "age BETWEEN 23 AND 29";
                            break;
                        case '30s':
                            $ageConditions[] = "age BETWEEN 30 AND 39";
                            break;
                        case '40s':
                            $ageConditions[] = "age BETWEEN 40 AND 49";
                            break;
                        case '50s':
                            $ageConditions[] = "age BETWEEN 50 AND 59";
                            break;
                        case '60s':
                            $ageConditions[] = "age BETWEEN 60 AND 69";
                            break;
                        case '70s':
                            $ageConditions[] = "age BETWEEN 70 AND 79";
                            break;
                    }
                }
                if (!empty($ageConditions)) {
                    $sql .= " AND (" . implode(' OR ', $ageConditions) . ")";
                }
            }

            // 性別条件
            if ($gender && !in_array('all', $gender)) {
                $sql .= " AND profile.gender_id IN (" . implode(',', array_map('intval', $gender)) . ")";
            }

            // 現住居条件
            if ($residence && !in_array('all', $residence)) {
                $sql .= " AND profile.residence_id IN (" . implode(',', array_map('intval', $residence)) . ")";
            }

            // 学校名条件
            if ($school && !in_array('all', $school)) {
                $sql .= " AND profile.school_id IN (" . implode(',', array_map('intval', $school)) . ")";
            }

            // 趣味条件
            if ($hobby && !in_array('all', $hobby)) {
                $sql .= " AND profile.hobby_id IN (" . implode(',', array_map('intval', $hobby)) . ")";
            }

            $sql .= " ORDER BY profile.age ASC";

            // SQLを実行
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    ?>

    <?php if (!empty($results)): ?>
        <ul class="recommendation2">
            <?php foreach ($results as $profile): ?>
                <li class="user-set2">
                    <?php
                    $default_icon = '../user_image/main/1.png';
                    $icon_path = empty($profile['icon_image']) ? $default_icon : "../user_image/main/{$profile['icon_image']}";
                    ?>
                    <?php if((int)$profile['gender_id'] === 1): // 男性 ?>
                        <div class="frame-blue2">
                    <?php elseif((int)$profile['gender_id'] === 2): // 女性 ?>
                        <div class="frame-pink2">
                    <?php else: // その他 ?>
                        <div class="frame-gray2">
                    <?php endif; ?>
                    <a href="../profile/profile-user.php?user_id=<?php echo htmlspecialchars($profile['user_id']); ?>">
                        <img src="<?php echo htmlspecialchars($icon_path); ?>" alt="icon" class="standard-icon">
                    </a>
                    </div>
                    <div class="nick_name2">
                        <?php echo htmlspecialchars($profile['user_name']); ?>
                        (<?php echo htmlspecialchars($profile['age']); ?>)
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>検索結果がありません。</p>
    <?php endif; ?>

</div>

</body>
</html>
