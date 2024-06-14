<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="css/user_ichiran.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー一覧</title>
    <style>
        /* 必要なCSSスタイルをここに記述 */
    </style>
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
                SELECT u.user_name, u.mail, p.gender, p.age
                FROM user u
                INNER JOIN profile p ON u.user_id = p.user_id
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
                echo '<td><a href="../profile/profile-user.php">プロフィールへ</a></td>';
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// データベース接続解除
$pdo = null;
?>
