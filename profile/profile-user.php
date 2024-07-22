<?php require '../header.php'; ?>
<?php require '../menu/menu.php'; ?>
<title>プロフィール</title>
<link rel="stylesheet" href="css/profile-user.css">
</head>
<body>
    <div class="container">

        <?php
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // user_id をクエリパラメータから取得
            $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

            // プロフィール情報を取得するSQLクエリ
            $sql = 'SELECT p.*, h.hobby_name, g.gender_name, s.school_name, b.birthplace_name, r.residence_name, d.blood_type_name, u.user_name
                    FROM profile p
                    LEFT JOIN hobby h ON p.hobby_id = h.hobby_id
                    LEFT JOIN gender g ON p.gender_id = g.gender_id
                    LEFT JOIN school s ON p.school_id = s.school_id
                    LEFT JOIN blood_type d ON p.blood_type_id = d.blood_type_id
                    LEFT JOIN birthplace b ON p.birthplace_id = b.birthplace_id
                    LEFT JOIN residence r ON p.residence_id = r.residence_id
                    LEFT JOIN user u ON p.user_id = u.user_id
                    WHERE p.user_id = :user_id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $profile = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($profile) {
                // デフォルトアイコンの設定
                $default_icon = '../user_image/main/1.png';
                $default_image = '../user_image/sub/no_image.png'; // デフォルト画像のパス

                $icon_path = empty($profile['icon_image']) ? $default_icon : "../user_image/main/{$profile['icon_image']}";

                $sub_a_image_path = empty($profile['sub_a_image']) ? $default_image : "../user_image/sub/{$profile['sub_a_image']}";
                $sub_b_image_path = empty($profile['sub_b_image']) ? $default_image : "../user_image/sub/{$profile['sub_b_image']}";
                $sub_c_image_path = empty($profile['sub_c_image']) ? $default_image : "../user_image/sub/{$profile['sub_c_image']}";

                // ユーザー名の表示
                echo '<div class="username">';
                echo '<h2><span class="name-box">' . htmlspecialchars($profile['user_name'] ?? '', ENT_QUOTES, 'UTF-8') . '</span></h2>';
                echo '</div>';
                echo '<button onclick="goBack()" class="modo">戻る</button>';
                echo '<hr>';
                // アイコン画像の表示
                echo '<div class="profile-icon-container">';
                echo '<img src="' . htmlspecialchars($icon_path, ENT_QUOTES, 'UTF-8') . '" alt="アイコン" class="profile-icon">';
                echo '</div>';

                // 追加画像の表示
                echo '<div class="sub-images">';
                echo '<div class="sub-image-wrapper">';
                echo '<div class="sub-square" id="subImageContainer1">';
                echo '<img id="subImage1" src="' . htmlspecialchars($sub_a_image_path, ENT_QUOTES, 'UTF-8') . '" alt="画像A">';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="sub-image-wrapper">';
                echo '<div class="sub-square" id="subImageContainer2">';
                echo '<img id="subImage2" src="' . htmlspecialchars($sub_b_image_path, ENT_QUOTES, 'UTF-8') . '" alt="画像B">';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="sub-image-wrapper">';
                echo '<div class="sub-square" id="subImageContainer3">';
                echo '<img id="subImage3" src="' . htmlspecialchars($sub_c_image_path, ENT_QUOTES, 'UTF-8') . '" alt="画像C">';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                // 趣味名の表示
                echo '<p><span class="label">趣味</span><br></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['hobby_name'] ?? '', ENT_QUOTES, 'UTF-8') . '</span></p>';
                
                // その他のプロフィール情報の表示
                echo '<p><span class="label">自己紹介</span></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['introduction'] ?? '') . '</span></p>';
                
                echo '<p><span class="label">性別</span></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['gender_name'] ?? '') . '</span></p>';
                
                echo '<p><span class="label">年齢</span></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['age'] ?? '') . '</span></p>';
                
                echo '<p><span class="label">血液型</span></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['blood_type_name'] ?? '') . '</span></p>';
                
                echo '<p><span class="label">学校</span></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['school_name'] ?? '') . '</span></p>';
                
                echo '<p><span class="label">出生地</span></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['birthplace_name'] ?? '') . '</span></p>';
                
                echo '<p><span class="label">居住地</span></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['residence_name'] ?? '') . '</span></p>';
                
                echo '<p><span class="label">休日の過ごし方</span></p>';
                echo '<p><span class="data-box">' . htmlspecialchars($profile['holiday_spend'] ?? '') . '</span></p>';

                // いいねボタンの表示（フォーム形式）
                echo '<div class="like-section">';
                echo '<form action="../likes/Like.php" method="post">';
                echo '<input type="hidden" name="liked_user_id" value="' . $profile['user_id'] . '">'; // user_id に修正
                echo '<input type="hidden" name="user_id" value="' . $_SESSION['user']['id'] . '">';
                echo '<button type="submit" class="like-button">
                    <img src="../menu-image/like-free-icon.png" alt="いいね"></button>';
                echo '</form>';
                echo '</div>'; // .like-section

            } else {
                echo '<p>プロフィールが見つかりません。</p>';
            }

        } catch (PDOException $e) {
            die("データベース接続に失敗しました: " . $e->getMessage());
        }
        ?>

    </div> <!-- .container -->

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
