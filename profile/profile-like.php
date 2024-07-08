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

            // user_id をクエリパラメータから取得
            $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

            if ($user_id > 0) {
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
                    // アイコン画像の表示
                    echo '<div class="profile-icon-container">';
                    if (!empty($profile['icon_image'])) {
                        echo '<img src="../user_image/main/' . htmlspecialchars($profile['icon_image'], ENT_QUOTES, 'UTF-8') . '" alt="アイコン" class="profile-icon">';
                    }
                    echo'</div>';

                    echo '<div class="username">';
                    echo '<p><span class="label">ユーザー名:</span><br><span class="data-box">' . htmlspecialchars($profile['user_name'] ?? '', ENT_QUOTES, 'UTF-8') . '</span></p>';
                    echo '</div>';
                    // 趣味名の表示
                    echo '<p><span class="label">趣味:</span><br><span class="data-box">' . htmlspecialchars($profile['hobby_name'] ?? '', ENT_QUOTES, 'UTF-8') . '</span></p>';
                    
                    // その他のプロフィール情報の表示
                    echo '<p><span class="label">自己紹介:</span></p>';
                    echo '<p><span class="data-box">' . htmlspecialchars($profile['introduction'] ?? '') . '</span></p>';
                    
                    echo '<p><span class="label">性別:</span></p>';
                    echo '<p><span class="data-box">' . htmlspecialchars($profile['gender_name'] ?? '') . '</span></p>';
                    
                    echo '<p><span class="label">年齢:</span></p>';
                    echo '<p><span class="data-box">' . htmlspecialchars($profile['age'] ?? '') . '</span></p>';
                    
                    echo '<p><span class="label">血液型:</span></p>';
                    echo '<p><span class="data-box">' . htmlspecialchars($profile['blood_type_name'] ?? '') . '</span></p>';
                    
                    echo '<p><span class="label">学校:</span></p>';
                    echo '<p><span class="data-box">' . htmlspecialchars($profile['school_name'] ?? '') . '</span></p>';
                    
                    echo '<p><span class="label">出生地:</span></p>';
                    echo '<p><span class="data-box">' . htmlspecialchars($profile['birthplace_name'] ?? '') . '</span></p>';
                    
                    echo '<p><span class="label">居住地:</span></p>';
                    echo '<p><span class="data-box">' . htmlspecialchars($profile['residence_name'] ?? '') . '</span></p>';
                    
                    
                    
                } else {
                    echo '<p>プロフィールが見つかりません。</p>';
                }
            } else {
                echo '<p>無効なユーザーIDです。</p>';
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
