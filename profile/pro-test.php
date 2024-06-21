<?php require '../header.php'; ?>
<?php require '../menu/menu.php'; ?> <!-- menuはbodyタグの中に絶対に入れるように -->
<title>プロフィール</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- ログアウトボタン -->
        <div class="open_sub_window_wrapper">
            <form action="../logout/logout.php" method="post">
                <button type="button" class="open_sub_window" onclick="openSubWindow()">ログアウト</button>
            </form>
        </div>
        <button onclick="goBack()">戻る</button>
        <!-- サブウィンドウの背景（クリックでサブウィンドウを閉じる） -->
        <div class="bg_sub_window" onclick="closeSubWindow()">
            <!-- サブウィンドウの内容 -->
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

        <?php
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // profile_id を 1 に設定
            $profile_id = 1;

            // プロフィール情報を取得するSQLクエリ
            $sql = 'SELECT * FROM profile WHERE profile_id = :profile_id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
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
                        $image_data = htmlspecialchars($profile[$field_name], ENT_QUOTES, 'UTF-8');
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($image_data) . '" alt="' . $label . '">';
                    } else {
                        echo '<p>' . $label . 'が見つかりません。</p>';
                    }
                    echo '</div>'; // .sub-photo-container
                }

                echo '</div>'; // .sub-photos
                echo '</div>'; // .sub-photo-section

                // その他のプロフィール情報の表示
                echo '<div class="profile-info">';
                echo '<p><span class="label">ユーザーID:</span> ' . htmlspecialchars($profile['user_id']) . '</p>';
                echo '<p><span class="label">自己紹介:</span> ' . htmlspecialchars($profile['introduction']) . '</p>';
                echo '<p><span class="label">趣味ID:</span> ' . htmlspecialchars($profile['hobby_id']) . '</p>';
                echo '<p><span class="label">性別:</span> ' . htmlspecialchars($profile['gender']) . '</p>';
                echo '<p><span class="label">年齢:</span> ' . htmlspecialchars($profile['age']) . '</p>';
                echo '<p><span class="label">血液型:</span> ' . htmlspecialchars($profile['blood_type']) . '</p>';
                echo '<p><span class="label">学校:</span> ' . htmlspecialchars($profile['school']) . '</p>';
                echo '<p><span class="label">出生地:</span> ' . htmlspecialchars($profile['birthplace']) . '</p>';
                echo '<p><span class="label">居住地:</span> ' . htmlspecialchars($profile['residence']) . '</p>';
                echo '</div>'; // .profile-info

            } else {
                echo '<p>プロフィールが見つかりません。</p>';
            }

        } catch (PDOException $e) {
            die("データベース接続に失敗しました: " . $e->getMessage());
        }
        ?>

    </div> <!-- .container -->

    <script>
        function openSubWindow() {
            document.querySelector('.bg_sub_window').style.visibility = 'visible';
            document.querySelector('.bg_sub_window').style.opacity = '1';
            document.querySelector('.bg_sub_window').style.pointerEvents = 'auto';
        }

        function closeSubWindow() {
            document.querySelector('.bg_sub_window').style.visibility = 'hidden';
            document.querySelector('.bg_sub_window').style.opacity = '0';
            document.querySelector('.bg_sub_window').style.pointerEvents = 'none';
        }

        function goBack() {
                window.history.back();
            }
    </script>
</body>
</html>
