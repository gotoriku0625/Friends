<?php require '../header.php'; ?>
<?php require '../menu/menu.php'; ?>
<title>プロフィール</title>
<link rel="stylesheet" href="css/profile-user.css">
</head>
<body>
    <div class="container">
        <button onclick="goBack()">戻る</button>
        <hr>

        <?php
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // profile_id をクエリパラメータから取得
            $profile_id = isset($_GET['profile_id']) ? (int)$_GET['profile_id'] : 1;

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
                    WHERE p.profile_id = :profile_id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':profile_id', $profile_id, PDO::PARAM_INT);
            $stmt->execute();

            $profile = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($profile) {
                // アイコン画像の表示
                if (!empty($profile['icon_image'])) {
                    echo '<img src="' . htmlspecialchars($profile['icon_image']) . '" alt="アイコン" class="profile-icon">';
                }

                // ユーザー名の表示
                echo '<p><span class="label">ユーザー名:</span> <span class="data-box">' . htmlspecialchars($profile['user_name'] ?? '') . '</span></p>';

                // 趣味名の表示
                echo '<p><span class="label">趣味:</span> <span class="data-box">' . htmlspecialchars($profile['hobby_name'] ?? '') . '</span></p>';

                // その他のプロフィール情報の表示
                echo '<p><span class="label">自己紹介:</span> <span class="data-box">' . htmlspecialchars($profile['introduction'] ?? '') . '</span></p>';
                echo '<p><span class="label">性別:</span> <span class="data-box">' . htmlspecialchars($profile['gender_name'] ?? '') . '</span></p>';
                echo '<p><span class="label">年齢:</span> <span class="data-box">' . htmlspecialchars($profile['age'] ?? '') . '</span></p>';
                echo '<p><span class="label">血液型:</span> <span class="data-box">' . htmlspecialchars($profile['blood_type_name'] ?? '') . '</span></p>';
                echo '<p><span class="label">学校:</span> <span class="data-box">' . htmlspecialchars($profile['school_name'] ?? '') . '</span></p>';
                echo '<p><span class="label">出生地:</span> <span class="data-box">' . htmlspecialchars($profile['birthplace_name'] ?? '') . '</span></p>';
                echo '<p><span class="label">居住地:</span> <span class="data-box">' . htmlspecialchars($profile['residence_name'] ?? '') . '</span></p>';

                // いいねボタンの表示（フォーム形式）
                echo '<div class="like-section">';
                echo '<form action="../likes/Like.php" method="post">';
                echo '<input type="hidden" name="profile_id" value="' . $profile_id . '">';
                echo '<input type="hidden" name="user_id" value="' . $_SESSION['user']['id'] . '">';
                echo '<button type="submit">いいね</button>';
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
