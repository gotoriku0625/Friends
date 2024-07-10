<?php require '../m_header.php'; ?>
<link rel="stylesheet" href="css/kanrisutaffu_settei.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理スタッフ設定</title>
<body>
    <?php require '../m_menu/m_menu.php'; ?>
    <div class="main">
    <?php $pdo = new PDO($connect, USER, PASS); ?>
</body>

<!DOCTYPE html>
<html lang="ja">
<head>
    
</head>
<body>
    <h1>管理スタッフ設定</h1>
        
       <?php
        $stmt = $pdo->query('SELECT m_user_id, mail, m_user_name, torokubi FROM management_user');
        
        // 管理者数の取得
        $adminCount = $stmt->rowCount();
        echo "管理者数：" . $adminCount;
    ?>
    <div class="tuika_button">
    <form action="kanrisutaffu_tuika.php">
        <button type="submit">スタッフ追加</button>
    </form>
</div>
<div class="sakujo_button">
    <form action="kanrisutaffu_sakujyo.php">
        <button type="submit">スタッフ削除</button>
    </form>
</div>
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
