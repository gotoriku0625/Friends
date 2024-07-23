<?php
require '../header.php';
require '../menu/menu.php'; // menuはbodyタグの中に絶対に入れるように
?>
<title>プロフィール</title>
<link rel="stylesheet" href="css/profile.css">
<script src="js/style.js"></script>
</head>
<body>
    <div class="container">
    <div class="title">
        <p>プロフィール</p>
    </div>
    <!-- ログアウトボタン-->
    <!-- サブウィンドウを開くボタンの親要素 -->
        <div class="open_sub_window_wrapper">
            <form action="../logout/logout.php" method="post">
                <button type="button" class="open_sub_window" onclick="openSubWindow()">ログアウト</button>
            </form>
        </div>

        <!-- サブウィンドウの背景 -->
        <div class="bg_sub_window" onclick="closeSubWindow()">
            <!-- サブウィンドウの内容 -->
            <div class="sub_window" onclick="event.stopPropagation()">
                <h1 class="sub_window_title">ログアウトしますか？</h1>
                <div class="sub_window_content">
                    <form action="../logout/logout.php" method="post">
                        <button type="submit" class="btn-logout">はい</button>
                    </form>
                    <button class="btn-cancel" onclick="closeSubWindow()">いいえ</button>
                </div>
            </div>
        </div>

        <hr>

        <!-- プロフィール情報の編集フォーム -->
        <form action="./profile-upout.php" method="post" enctype="multipart/form-data">
            
            <?php
            $pdo = new PDO($connect, USER, PASS);
            $select = 'SELECT * FROM user, profile WHERE user.user_id = profile.user_id AND profile.user_id = ?';
            $sql = $pdo->prepare($select);
            $user_id = $_SESSION['user']['id'];
            
            if (isset($_SESSION['user']['id'])) {
                $sql->execute([$user_id]);
                foreach ($sql as $user) {
                    $default_icon = '../user_image/main/1.png';
                    $icon_path = empty($user['icon_image']) ? $default_icon : "../user_image/main/{$user['icon_image']}";
            ?>
                
                    <div class="icon-section">
                        <span>アイコン</span>
                        <div class="icon-container">
                            <img id="profileIcon" src="<?php echo $icon_path; ?>" alt="プロフィールアイコン">
                            <label for="iconInput" class="plus" onclick="uploadIcon()">+</label>
                            <input type="file" id="iconInput" name="icon" accept="image/*" style="display: none;">
                        </div>
                    </div>

                    <p>サブ写真</p>
                    <?php
                    $default_subImg = 'no_image.png';
                    $subImg_pathA = empty($user['sub_a_image']) ? $default_subImg : $user['sub_a_image'];
                    $subImg_pathB = empty($user['sub_b_image']) ? $default_subImg : $user['sub_b_image'];
                    $subImg_pathC = empty($user['sub_c_image']) ? $default_subImg: $user['sub_c_image'];
                    ?>
                    <div class="sub-images">
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer1">
                                <img id="subImage1" src="../user_image/sub/<?php echo $subImg_pathA; ?>">
                            </div>
                            <label for="subImageInput1" class="subImagePut" onclick="uploadSubImage('subImageInput1', 'subImage1')">+</label>
                            <input type="file" id="subImageInput1" name="subImage1" accept="image/*" style="display: none;">
                        </div>
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer2">
                                <img id="subImage2" src="../user_image/sub/<?php echo $subImg_pathB; ?>">
                            </div>
                            <label for="subImageInput2" class="subImagePut" onclick="uploadSubImage('subImageInput2', 'subImage2')">+</label>
                            <input type="file" id="subImageInput2" name="subImage2" accept="image/*" style="display: none;">
                        </div>
                        <div class="sub-image-wrapper">
                            <div class="sub-square" id="subImageContainer3">
                                <img id="subImage3" src="../user_image/sub/<?php echo $subImg_pathC; ?>">
                            </div>
                            <label for="subImageInput3" class="subImagePut" onclick="uploadSubImage('subImageInput3', 'subImage3')">+</label>
                            <input type="file" id="subImageInput3" name="subImage3" accept="image/*" style="display: none;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">ユーザー名</label>
                        <input type="text" id="username" name="username" value="<?php echo $user['user_name']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="selfIntro">自己紹介</label>
                        <textarea id="selfIntro" name="selfIntro" rows="5" maxlength="500" required><?php echo $user['introduction']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="category">趣味/特技</label>
                        <select name="category">
                            <?php
                            $hobby = $user['hobby_id'];
                            foreach ($pdo->query('SELECT * FROM hobby ORDER BY hobby_id') as $row) {
                                if ($hobby == $row['hobby_id']) {
                                    echo '<option value=', $hobby, ' selected>', $row['hobby_name'], '</option>';
                                } else {
                                    echo '<option value=', $row['hobby_id'], '>', $row['hobby_name'], '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="select-group">
                        <label for="gender">性別</label>
                        <select id="gender" name="gender" required>
                            <?php
                            $gender = $user['gender_id'];
                            foreach ($pdo->query('SELECT * FROM gender ORDER BY gender_id') as $row) {
                                if ($gender == $row['gender_id']) {
                                    echo '<option value=', $gender, ' selected>', $row['gender_name'], '</option>';
                                } else {
                                    echo '<option value=', $row['gender_id'], '>', $row['gender_name'], '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="select-group">
                        <label for="age">年齢</label>
                        <input type="number" id="age" name="age" value="<?php echo $user['age']; ?>" min="0" required>
                    </div>

                    <div class="select-group">
                        <label for="bloodType">血液型</label>
                        <select id="bloodType" name="bloodType">
                            <?php
                            $bloodType = $user['blood_type_id'];
                            foreach ($pdo->query('SELECT * FROM blood_type ORDER BY blood_type_id') as $row) {
                                if ($bloodType == $row['blood_type_id']) {
                                    echo '<option value=', $bloodType, ' selected>', $row['blood_type_name'], '</option>';
                                } else {
                                    echo '<option value=', $row['blood_type_id'], '>', $row['blood_type_name'], '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="select-group">
                        <label for="school">学校</label>
                        <select id="school" name="school">
                            <?php
                            $school = $user['school_id'];
                            foreach ($pdo->query('SELECT * FROM school ORDER BY school_id') as $row) {
                                if ($school == $row['school_id']) {
                                    echo '<option value=', $school, ' selected>', $row['school_name'], '</option>';
                                } else {
                                    echo '<option value=', $row['school_id'], '>', $row['school_name'], '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="select-group">
                        <label for="hometown">出身地</label>
                        <select id="hometown" name="hometown">
                            <?php
                            $birthPlace = $user['birthplace_id'];
                            foreach ($pdo->query('SELECT * FROM birthplace ORDER BY birthplace_id') as $row) {
                                if ($birthPlace == $row['birthplace_id']) {
                                    echo '<option value=', $birthPlace, ' selected>', $row['birthplace_name'], '</option>';
                                } else {
                                    echo '<option value=', $row['birthplace_id'], '>', $row['birthplace_name'], '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="select-group">
                        <label for="residence">居住地</label>
                        <select id="residence" name="residence">
                            <?php
                            $residence = $user['residence_id'];
                            foreach ($pdo->query('SELECT * FROM residence ORDER BY residence_id') as $row) {
                                if ($residence == $row['residence_id']) {
                                    echo '<option value=', $residence, ' selected>', $row['residence_name'], '</option>';
                                } else {
                                    echo '<option value=', $row['residence_id'], '>', $row['residence_name'], '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="spendHoliday">休日の過ごし方</label>
                        <textarea id="spendHoliday" name="spendHoliday" rows="4" cols="50" class="off"><?php echo $user['holiday_spend']; ?></textarea>
                    </div>

                    <div class="checkbox-group">
                        <label>
                            <input type='hidden' value='0' name='drinking'>
                            <input type="checkbox" name="drinking" value="1" <?php if ($user['alcohol'] == 1) echo 'checked'; ?>> 飲酒
                        </label>
                        <label>
                            <input type='hidden' value='0' name='smoking'>
                            <input type="checkbox" name="smoking" value="1" <?php if ($user['smoke'] == 1) echo 'checked'; ?>> 喫煙
                        </label>
                    </div>

                    <div class="form-group" id="submit_button">
                        <div class="btn-container">
                            <button type="submit" class="btn" name="btn" value="submit">保存</button>
                        </div>
                    </div>
            <?php }
            } ?>
        </form>
    </div>
</body>
</html>
