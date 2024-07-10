<?php
session_start();
require '../db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO($connect, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user_id = $_SESSION['user']['id'];
        $username = $_POST['username'];
        $selfIntro = $_POST['selfIntro'];
        $hobby_id = $_POST['category'];
        $gender_id = $_POST['gender'];
        $age = $_POST['age'];
        $bloodType_id = $_POST['bloodType'];
        $school_id = $_POST['school'];
        $birthplace_id = $_POST['hometown'];
        $residence_id = $_POST['residence'];
        $holiday_spend = $_POST['message'];
        $drinking = isset($_POST['drinking']) ? 1 : 0;
        $smoking = isset($_POST['smoking']) ? 1 : 0;

        // アイコンとサブ写真の処理
        $icon_image = $_FILES['icon']['name'];
        $sub_a_image = $_FILES['subImage1']['name'];
        $sub_b_image = $_FILES['subImage2']['name'];
        $sub_c_image = $_FILES['subImage3']['name'];

        // 画像アップロード
        if ($icon_image) {
            move_uploaded_file($_FILES['icon']['tmp_name'], "../user_image/main/$icon_image");
        }
        if ($sub_a_image) {
            move_uploaded_file($_FILES['subImage1']['tmp_name'], "../user_image/sub/$sub_a_image");
        }
        if ($sub_b_image) {
            move_uploaded_file($_FILES['subImage2']['tmp_name'], "../user_image/sub/$sub_b_image");
        }
        if ($sub_c_image) {
            move_uploaded_file($_FILES['subImage3']['tmp_name'], "../user_image/sub/$sub_c_image");
        }

        // プロフィール情報の更新
        $sql = "INSERT INTO profile (user_id, introduction, hobby_id, gender_id, age, blood_type_id, school_id, birthplace_id, residence_id, holiday_spend, icon_image, sub_a_image, sub_b_image, sub_c_image, alcohol, smoke) 
                VALUES (:user_id, :introduction, :hobby_id, :gender_id, :age, :blood_type_id, :school_id, :birthplace_id, :residence_id, :holiday_spend, :icon_image, :sub_a_image, :sub_b_image, :sub_c_image, :alcohol, :smoke)
                ON DUPLICATE KEY UPDATE 
                introduction=:introduction, hobby_id=:hobby_id, gender_id=:gender_id, age=:age, blood_type_id=:blood_type_id, school_id=:school_id, birthplace_id=:birthplace_id, residence_id=:residence_id, holiday_spend=:holiday_spend, icon_image=:icon_image, sub_a_image=:sub_a_image, sub_b_image=:sub_b_image, sub_c_image=:sub_c_image, alcohol=:alcohol, smoke=:smoke";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':introduction', $selfIntro, PDO::PARAM_STR);
        $stmt->bindValue(':hobby_id', $hobby_id, PDO::PARAM_INT);
        $stmt->bindValue(':gender_id', $gender_id, PDO::PARAM_INT);
        $stmt->bindValue(':age', $age, PDO::PARAM_INT);
        $stmt->bindValue(':blood_type_id', $bloodType_id, PDO::PARAM_INT);
        $stmt->bindValue(':school_id', $school_id, PDO::PARAM_INT);
        $stmt->bindValue(':birthplace_id', $birthplace_id, PDO::PARAM_INT);
        $stmt->bindValue(':residence_id', $residence_id, PDO::PARAM_INT);
        $stmt->bindValue(':holiday_spend', $holiday_spend, PDO::PARAM_STR);
        $stmt->bindValue(':icon_image', $icon_image, PDO::PARAM_STR);
        $stmt->bindValue(':sub_a_image', $sub_a_image, PDO::PARAM_STR);
        $stmt->bindValue(':sub_b_image', $sub_b_image, PDO::PARAM_STR);
        $stmt->bindValue(':sub_c_image', $sub_c_image, PDO::PARAM_STR);
        $stmt->bindValue(':alcohol', $drinking, PDO::PARAM_INT);
        $stmt->bindValue(':smoke', $smoking, PDO::PARAM_INT);
        $stmt->execute();

        // 成功したらtop.phpにリダイレクト
        header("Location: ../top/top.php");
        exit();

    } catch (PDOException $e) {
        die("データベース接続に失敗しました: " . $e->getMessage());
    }
}
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
        <div class="bg_sub_window" onclick="closeSubWindow()">
            <div class="sub_window" onclick="event.stopPropagation()">
                <div class="sub_window_content">
                    <form action="../logout/logout.php" method="post">
                        <button type="submit" class="btn-logout">はい</button>
                    </form>
                    <button class="btn-cancel" onclick="closeSubWindow()">いいえ</button>
                </div>
            </div>
        </div>
        <hr>
        <form action="./profile.php" method="post" enctype="multipart/form-data">
            <?php
            $pdo = new PDO($connect, USER, PASS);
            $select = 'SELECT * FROM user LEFT JOIN profile ON user.user_id = profile.user_id WHERE user.user_id = ?';
            $sql = $pdo->prepare($select);
            $user_id = $_SESSION['user']['id'];

            if (isset($_SESSION['user']['id'])) {
                $sql->execute([$user_id]);
                $user = $sql->fetch();

                echo <<<EOF
                <div class="icon-section">
                    <span>アイコンの変更</span>
                    <div class="icon-container">
                        <img id="profileIcon" src="../user_image/main/{$user['icon_image']}" alt="プロフィールアイコン">
                        <label for="iconInput" class="plus" onclick="uploadIcon()">+</label>
                        <input type="file" id="iconInput" name="icon" accept="image/*" style="display: none;">
                    </div>
                </div>

                <p>サブ写真</p>
                <div class="sub-images">
                    <div class="sub-image-wrapper">
                        <div class="sub-square" id="subImageContainer1">
                            <img id="subImage1" src="../user_image/sub/{$user['sub_a_image']}">
                        </div>
                        <label for="subImageInput1" class="subImagePut" onclick="uploadSubImage('subImageInput1', 'subImage1')">+</label>
                        <input type="file" id="subImageInput1" name="subImage1" accept="image/*" style="display: none;">
                    </div>
                    <div class="sub-image-wrapper">
                        <div class="sub-square" id="subImageContainer2">
                            <img id="subImage2" src="../user_image/sub/{$user['sub_b_image']}">
                        </div>
                        <label for="subImageInput2" class="subImagePut" onclick="uploadSubImage('subImageInput2', 'subImage2')">+</label>
                        <input type="file" id="subImageInput2" name="subImage2" accept="image/*" style="display: none;">
                    </div>
                    <div class="sub-image-wrapper">
                        <div class="sub-square" id="subImageContainer3">
                            <img id="subImage3" src="../user_image/sub/{$user['sub_c_image']}">
                        </div>
                        <label for="subImageInput3" class="subImagePut" onclick="uploadSubImage('subImageInput3', 'subImage3')">+</label>
                        <input type="file" id="subImageInput3" name="subImage3" accept="image/*" style="display: none;">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="username">ユーザー名</label>
                    <input type="text" id="username" name="username" value="{$user['user_name']}" required>
                </div>
                <div class="form-group">
                    <label for="selfIntro">自己紹介</label>
                    <textarea id="selfIntro" name="selfIntro" rows="5" maxlength="500" required>{$user['introduction']}</textarea>
                </div>
                <div class="form-group">
                    <label for="hobbies">趣味/特技</label>
                    <select name="category">
EOF;
                $hobby = $user['hobby_id'];
                foreach ($pdo->query('SELECT * FROM hobby ORDER BY hobby_id') as $row) {
                    if ($hobby == $row['hobby_id']) {
                        echo '<option value=', $hobby, ' selected>', $row['hobby_name'], '</option>';
                    } else {
                        echo '<option value=', $row['hobby_id'], '>', $row['hobby_name'], '</option>';
                    }
                }
                echo '</select>';
                echo '</div>';
                $gender = $user['gender_id'];
                echo '<div class="select-group">';
                echo '<label for="gender">性別</label>';
                echo '<select id="gender" name="gender" required>';
                foreach ($pdo->query('SELECT * FROM gender ORDER BY gender_id') as $row) {
                    if ($gender == $row['gender_id']) {
                        echo '<option value=', $gender, ' selected>', $row['gender_name'], '</option>';
                    } else {
                        echo '<option value=', $row['gender_id'], '>', $row['gender_name'], '</option>';
                    }
                }
                echo '</select>';
                echo '</div>';
                echo <<<EOF
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
                    if ($bloodType == $row['blood_type_id']) {
                        echo '<option value=', $bloodType, ' selected>', $row['blood_type_name'], '</option>';
                    } else {
                        echo '<option value=', $row['blood_type_id'], '>', $row['blood_type_name'], '</option>';
                    }
                }
                echo <<<EOF
                   </select>
                </div>
                <div class="select-group">
                    <label for="school">学校</label>
EOF;
                echo '<select id="school" name="school">';
                $school = $user['school_id'];
                foreach ($pdo->query('SELECT * FROM school ORDER BY school_id') as $row) {
                    if ($school == $row['school_id']) {
                        echo '<option value=', $school, ' selected>', $row['school_name'], '</option>';
                    } else {
                        echo '<option value=', $row['school_id'], '>', $row['school_name'], '</option>';
                    }
                }
                echo '</select>
                </div>
                <div class="select-group">
                    <label for="hometown">出身地</label>';
                    echo '<select id="hometown" name="hometown">';
                    $birthPlace = $user['birthplace_id'];
                    foreach ($pdo->query('SELECT * FROM birthplace ORDER BY birthplace_id') as $row) {
                        if ($birthPlace == $row['birthplace_id']) {
                            echo '<option value=', $birthPlace, ' selected>', $row['birthplace_name'], '</option>';
                        } else {
                            echo '<option value=', $row['birthplace_id'], '>', $row['birthplace_name'], '</option>';
                        }
                    }
                    echo <<<EOF
                    </select>
                </div>
                <div class="select-group">
                    <label for="residence">居住地</label>
EOF;
                    echo '<select id="residence" name="residence">';
                    $residence = $user['residence_id'];
                    foreach ($pdo->query('SELECT * FROM residence ORDER BY residence_id') as $row) {
                        if ($residence == $row['residence_id']) {
                            echo '<option value=', $residence, ' selected>', $row['residence_name'], '</option>';
                        } else {
                            echo '<option value=', $row['residence_id'], '>', $row['residence_name'], '</option>';
                        }
                    }
                    echo <<<EOF
                    </select>
                </div>
                <div class="form-group">
                    <label for="spendHoliday">休日の過ごし方</label>
                    <textarea id="message" name="message" rows="4" cols="500" required>{$user['holiday_spend']}</textarea>
                </div>
EOF;
                echo '<div class="checkbox-group">';
                echo '<label>';
                if ($user['alcohol'] == 1) {
                    echo '<input type="hidden" name="drinking" value="0">';
                    echo '<input type="checkbox" name="drinking" value="1" checked>飲酒';
                } else {
                    echo '<input type="hidden" name="drinking" value="0">';
                    echo '<input type="checkbox" name="drinking" value="1">飲酒';
                }
                echo '</label>';
                echo '<label>';
                if ($user['smoke'] == 1) {
                    echo '<input type="hidden" name="smoking" value="0">';
                    echo '<input type="checkbox" name="smoking" value="1" checked> 喫煙';
                } else {
                    echo '<input type="hidden" name="smoking" value="0">';
                    echo '<input type="checkbox" name="smoking" value="1">喫煙';
                }
                echo '</label>';
                echo '</div>';
            }
            ?>
            <div class="form-group" id="submit_button">
                <div class="btn-container">
                    <button type="submit" class="btn" name="btn" value="submit">保存</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
