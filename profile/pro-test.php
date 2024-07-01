<?php require '../header.php'; ?>
<?php require '../menu/menu.php'; ?>
<title>プロフィール</title>
<link rel="stylesheet" href="css/style.css">
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
            $sql = 'SELECT * FROM profile WHERE profile_id = :profile_id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':profile_id', $profile_id, PDO::PARAM_INT);
            $stmt->execute();

            $profile = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($profile) {
                // サブ写真の表示
                echo '<div class="sub-photo-section">';
                echo '<span>サブ写真</span>';
                echo '<div class="sub-photos">';

                $sub_images = array(
                    'sub_a_image' => 'サブ写真1',
                    'sub_b_image' => 'サブ写真2',
                    'sub_c_image' => 'サブ写真3'
                );

                foreach ($sub_images as $field_name => $label) {
                    echo '<div class="sub-photo-container">';
                    if (!empty($profile[$field_name])) {
                        $image_data = $profile[$field_name];
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($image_data) . '" alt="' . $label . '">';
                    } else {
                        echo '<p>' . $label . 'が見つかりません。</p>';
                    }
                    echo '</div>'; // .sub-photo-container
                }

                echo '</div>'; // .sub-photos
                echo '</div>'; // .sub-photo-section

                // その他のプロフィール情報の表示
                echo '<div class="form-group">';
                echo '<p><span class="label">ユーザーID:</span> <span class="data-box">' . htmlspecialchars($profile['user_id'] ?? '') . '</span></p>';
                echo '<p><span class="label">自己紹介:</span> <span class="data-box">' . htmlspecialchars($profile['introduction'] ?? '') . '</span></p>';
                echo '<p><span class="label">趣味ID:</span> <span class="data-box">' . htmlspecialchars($profile['hobby_id'] ?? '') . '</span></p>';
                echo '<p><span class="label">性別:</span> <span class="data-box">' . htmlspecialchars($profile['gender_id'] ?? '') . '</span></p>';
                echo '<p><span class="label">年齢:</span> <span class="data-box">' . htmlspecialchars($profile['age'] ?? '') . '</span></p>';
                echo '<p><span class="label">血液型:</span> <span class="data-box">' . htmlspecialchars($profile['blood_type'] ?? '') . '</span></p>';
                echo '<p><span class="label">学校:</span> <span class="data-box">' . htmlspecialchars($profile['school'] ?? '') . '</span></p>';
                echo '<p><span class="label">出生地:</span> <span class="data-box">' . htmlspecialchars($profile['birthplace'] ?? '') . '</span></p>';
                echo '<p><span class="label">居住地:</span> <span class="data-box">' . htmlspecialchars($profile['residence'] ?? '') . '</span></p>';

                // いいねボタンの表示（フォーム形式）
                echo '<div class="like-section">';
                echo '<form action="../likes/Like.php" method="post">';
                echo '<input type="hidden" name="profile_id" value="' . $profile_id . '">';
                echo '<input type="hidden" name="user_id" value="' . $_SESSION['user_id'] . '">';
                echo '<button type="submit">いいね</button>';
                echo '</form>';
                echo '</div>'; // .like-section

                echo '</div>'; // .form-group

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
