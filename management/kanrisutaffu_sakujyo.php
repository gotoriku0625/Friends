<?php require '../m_header.php'; ?>

<body>
    <?php require '../m_menu/m_menu.php'; ?>
    <div class="main">
    <?php $pdo = new PDO($connect, USER, PASS); ?>
</body>
<?php
// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $idsToDelete = $_POST['delete'];
    foreach ($idsToDelete as $id) {
        $stmt = $pdo->prepare("DELETE FROM management_user WHERE m_user_id = ?");
        $stmt->execute([$id]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // チェックボックスが選択されていない場合のエラーメッセージ
    echo "<script>displayErrorMessage('削除するスタッフを選択してください。');</script>";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="css/kanrisutaffu_sakujyo.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理スタッフ設定</title>
    <style>
        .error-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 8px;
            z-index: 1000; /* オーバーレイの重なりを設定 */
            display: none; /* 初期状態では非表示 */
        }
    </style>
    <script>
        function displayErrorMessage(message) {
            var errorMessageElement = document.getElementById('error-message');
            errorMessageElement.innerText = message;
            errorMessageElement.style.display = 'block'; // メッセージを表示
            setTimeout(function() {
                errorMessageElement.style.display = 'none'; // 5秒後に自動的に非表示にする
            }, 5000); // 5000ミリ秒 = 5秒
        }

        function confirmDeletion() {
            var checked = document.querySelectorAll('input[name="delete[]"]:checked').length;
            if (checked === 0) {
                displayErrorMessage('削除するスタッフを選択してください。');
                return false; // フォーム送信を中止
            }
            return confirm('選択されたスタッフを本当に削除しますか？');
        }
    </script>
</head>
<body>
    <h1>管理スタッフ設定</h1>
    
    <?php
        $stmt = $pdo->query('SELECT m_user_id, mail, m_user_name, torokubi FROM management_user');
        
        // 管理者数の取得
        $adminCount = $stmt->rowCount();
        echo "管理者数：" . $adminCount,"人";
    ?>
   
    <form action="" method="post" onsubmit="return confirmDeletion();">
        <a href="kanrisutaffu_tuika.php"><button type="button" class="tuika">スタッフ追加</button></a>
    </form>
        <table>
            <thead>
                <tr>
                    <th>管理者名</th><th>管理者番号</th><th>email</th><th>追加日</th><th class="checkbox"></th>
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
                    echo "<td class='checkbox'><input type='checkbox' name='delete[]' value='" . htmlspecialchars($row['m_user_id'], ENT_QUOTES, 'UTF-8') . "'></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="sakujyo">削除</button>
    </form>
    
    <div id="error-message" class="error-message"></div>
</body>
</html>
