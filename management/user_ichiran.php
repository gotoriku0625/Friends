<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user_ichiran.css">
    <title>ユーザー一覧</title>
</head>

<body>
    <h1>ユーザー一覧</h1>
    <p>ユーザー数：
        <?php
        // データベース接続
        require '../db-connect.php';
        $pdo = new PDO($connect, USER, PASS);

        // ユーザー数を取得するクエリ
        $user_count_query = "SELECT COUNT(*) AS count FROM user";
        $user_count_result = $pdo->query($user_count_query);
        $user_count = $user_count_result->fetch(PDO::FETCH_ASSOC)['count'];

        echo $user_count; // ユーザー数を表示
        ?>
    </p>
    <table>
        <thead>
            <tr>
                <th>名前</th><th>email</th><th>性別</th><th>年齢</th><th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ユーザー情報を取得するクエリ
            $user_query = "
                SELECT u.user_id, u.user_name, u.mail, g.gender_name AS gender, p.age
                FROM user u
                INNER JOIN profile p ON u.user_id = p.user_id
                INNER JOIN gender g ON p.gender_id = g.gender_id
            ";

            // クエリ実行
            $result = $pdo->query($user_query);

            // 結果を取得してテーブルに表示
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['mail']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                echo "<td>" . htmlspecialchars($row['age']) . "歳</td>";
                echo '<td><a href="../profile/profile-user.php?id=' . $row['user_id'] . '">プロフィールへ</a></td>'; // ユーザーIDを使用してリンク先を個別化
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // データベース接続解除
    $pdo = null;
    ?>
</body>
</html>
