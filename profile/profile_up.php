<?php
require '../header.php';
require '../menu/menu.php'; // menu must be included inside the body tag
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>プロフィール</title>
    <link rel="stylesheet" href="css/profile.css">
    <script src="js/style.js"></script>
</head>
<body>
    <div class="container">
        <p class="title">プロフィール</p>
        <!-- Logout button -->
        <div class="open_sub_window_wrapper">
            <form action="../logout/logout.php" method="post">
                <button type="button" class="open_sub_window" onclick="openSubWindow()">ログアウト</button>
            </form>
        </div>
        <!-- Sub window background (click to close sub window) -->
        <div class="bg_sub_window" onclick="closeSubWindow()">
            <!-- Sub window content -->
            <div class="sub_window" onclick="event.stopPropagation()">
                <div class="sub_window_content">
                    <form action="../logout/logout.php" method="post">
                        <button type="submit" class="btn-logout">ログアウト</button>
                    </form>
                    <button class="btn-cancel" onclick="closeSubWindow()">キャンセル</button>
                </div>
            </div>
        </div>
        <hr>
        <!-- Form elements -->
        <form action="./profile-upout.php" method="post" enctype="multipart/form-data">
            <?php
            $pdo = new PDO($connect, USER, PASS);
            $select = 'SELECT * FROM user, profile WHERE user.user_id = profile.user_id AND profile.user_id = ?';
            $sql = $pdo->prepare($select);
            $user_id = $_SESSION['user']['id'];

            if (isset($_SESSION['user']['id'])) {
                $sql->execute([$user_id]);
                foreach ($sql as $user) {
                    echo <<<EOF
                    <div class="form-group">
                        <label for="username">ユーザー名</label>
                        <input type="text" id="username" name="username" value="{$user['user_name']}">
                    </div>
                    <div class="form-group">
                        <label for="selfIntro">自己紹介</label>
                        <textarea id="selfIntro" name="selfIntro" rows="5" maxlength="500" required>{$user['introduction']}</textarea>
                    </div>
                    <div class="icon-section">
                        <span>アイコンの変更</span>
                        <div class="icon-container">
                            <img id="profileIcon" src="../user_image/main/{$user['icon_image']}" alt="プロフィールアイコン">
                            <label for="iconInput" class="plus">+</label>
                            <input type="file" id="iconInput" name="icon" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    <p>サブ写真</p>
                    <div class="sub-images">
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer1">
                                <img id="subImage1" src="../user_image/sub/{$user['sub_a_image']}" alt="サブ写真1">
                            </div>
                            <label for="subImageInput1" class="subImagePut">+</label>
                            <input type="file" id="subImageInput1" name="subImage1" accept="image/*" style="display: none;">
                        </div>
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer2">
                                <img id="subImage2" src="../user_image/sub/{$user['sub_b_image']}" alt="サブ写真2">
                            </div>
                            <label for="subImageInput2" class="subImagePut">+</label>
                            <input type="file" id="subImageInput2" name="subImage2" accept="image/*" style="display: none;">
                        </div>
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer3">
                                <img id="subImage3" src="../user_image/sub/{$user['sub_c_image']}" alt="サブ写真3">
                            </div>
                            <label for="subImageInput3" class="subImagePut">+</label>
                            <input type="file" id="subImageInput3" name="subImage3" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hobbies">趣味/特技</label>
                        <select name="category" id="hobbies">
EOF;
                    $hobby = $user['hobby_id'];
                    foreach ($pdo->query('SELECT * FROM hobby ORDER BY hobby_id') as $row) {
                        $selected = $hobby == $row['hobby_id'] ? 'selected' : '';
                        echo "<option value='{$row['hobby_id']}' $selected>{$row['hobby_name']}</option>";
                    }
                    echo <<<EOF
                        </select>
                    </div>
                    <div class="select-group">
                        <label for="gender">性別</label>
                        <select id="gender" name="gender" required>
EOF;
                    $gender = $user['gender_id'];
                    foreach ($pdo->query('SELECT * FROM gender ORDER BY gender_id') as $row) {
                        $selected = $gender == $row['gender_id'] ? 'selected' : '';
                        echo "<option value='{$row['gender_id']}' $selected>{$row['gender_name']}</option>";
                    }
                    echo <<<EOF
                        </select>
                    </div>
                    <div class="select-group">
                        <label for="age">年齢</label>
                        <input type="number" id="age" name="age" value="{$user['age']}" min="0" required>
                    </div>
                    <div class="select-group">
                        <label for="bloodType">血液型</label>
                        <select id="bloodType" name="bloodType">
EOF;
                    $bloodType = $user['blood_type_id'];
                    foreach ($pdo->query('SELECT * FROM blood_type ORDER BY blood_type_id') as $row) {
                        $selected = $bloodType == $row['blood_type_id'] ? 'selected' : '';
                        echo "<option value='{$row['blood_type_id']}' $selected>{$row['blood_type_name']}</option>";
                    }
                    echo <<<EOF
                        </select>
                    </div>
                    <div class="select-group">
                        <label for="school">学校</label>
                        <select id="school" name="school">
EOF;
                    $school = $user['school_id'];
                    foreach ($pdo->query('SELECT * FROM school ORDER BY school_id') as $row) {
                        $selected = $school == $row['school_id'] ? 'selected' : '';
                        echo "<option value='{$row['school_id']}' $selected>{$row['school_name']}</option>";
                    }
                    echo <<<EOF
                        </select>
                    </div>
                    <div class="select-group">
                        <label for="hometown">出身地</label>
                        <select id="hometown" name="hometown">
EOF;
                    $birthPlace = $user['birthplace_id'];
                    foreach ($pdo->query('SELECT * FROM birthplace ORDER BY birthplace_id') as $row) {
                        $selected = $birthPlace == $row['birthplace_id'] ? 'selected' : '';
                        echo "<option value='{$row['birthplace_id']}' $selected>{$row['birthplace_name']}</option>";
                    }
                    echo <<<EOF
                        </select>
                    </div>
                    <div class="select-group">
                        <label for="residence">居住地</label>
                        <select id="residence" name="residence">
EOF;
                    $residence = $user['residence_id'];
                    foreach ($pdo->query('SELECT * FROM residence ORDER BY residence_id') as $row) {
                        $selected = $residence == $row['residence_id'] ? 'selected' : '';
                        echo "<option value='{$row['residence_id']}' $selected>{$row['residence_name']}</option>";
                    }
                    echo <<<EOF
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="spendHoliday">休日の過ごし方</label>
                        <textarea id="spendHoliday" name="spendHoliday" rows="4" required>{$user['holiday_spend']}</textarea>
                    </div>
                    <div class="checkbox-group">
                        <label>
                            <input type="hidden" name="drinking" value="0">
                            <input type="checkbox" name="drinking" value="1" {$user['alcohol'] == 1 ? 'checked' : ''}> 飲酒
                        </label>
                        <label>
                            <input type="hidden" name="smoking" value="0">
                            <input type="checkbox" name="smoking" value="1" {$user['smoke'] == 1 ? 'checked' : ''}> 喫煙
                        </label>
                    </div>
                    EOF;
                }
            }
            ?>
            <div class="form-group" id="submit_button">
                <div class="btn-container">
                    <a href="../login/login.html" class="btn">キャンセル</a>
                    <button type="submit" class="btn" name="btn" value="submit">保存</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
