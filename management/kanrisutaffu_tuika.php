<?php
require '../db-connect.php';
$pdo = new PDO($connect, USER, PASS);

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kanri_name = $_POST['kanri_name'];
    $kanri_number = $_POST['kanri_number'];
    $email = $_POST['email'];
    $tuikabi = date('Y-m-d'); // 現在の日付を取得

    // データベースに新しいユーザーを挿入
    $m_pass = 'Friends2024'; // 固定のパスワード
    $stmt = $pdo->prepare("INSERT INTO management_user (m_user_id, mail, m_pass, m_user_name, torokubi) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$kanri_number, $email, $m_pass, $kanri_name, $tuikabi]);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="css/kanrisutaffu_settei.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理スタッフ設定</title>
    <script>
        function confirmSubmission() {
            return confirm('このスタッフを追加しますか？');
        }
    </script>
</head>
<body>
    <h1>管理スタッフ設定</h1>
    
    <?php
        $stmt = $pdo->query('SELECT m_user_id, mail, m_user_name, torokubi FROM management_user');
        
        // 管理者数の取得
        $adminCount = $stmt->rowCount();
        echo "管理者数：" . $adminCount;
    ?>

    <form action="" method="post" onsubmit="return confirmSubmission();">
        <p>管理者名<br>
            <input type="text" name="kanri_name" size="30">
        </p>
        <p>管理者番号<br>
            <input type="text" name="kanri_number" size="30">
        </p>
        <p>email<br>
            <input type="text" name="email" size="30">
        </p>
        <button type="submit">追加</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>管理者名</th><th>管理者番号</th><th>email</th><th>追加日</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // データの表示
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['m_user_name'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['m_user_id'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['mail'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['torokubi'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
