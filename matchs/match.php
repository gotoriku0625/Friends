<?php require '../header.php'; ?>
<?php
$pdo = new PDO($connect, USER, PASS);

// POSTデータからユーザーIDを取得
$user_id = $_POST['user_id'];
$logged_in_user_id = $_SESSION['user']['id'];

// マッチングのチェック
$sql_check_match = "SELECT * FROM matchs WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id1 = ? AND user_id2 = ?)";
$stmt_check_match = $pdo->prepare($sql_check_match);
$stmt_check_match->execute([$logged_in_user_id, $user_id, $user_id, $logged_in_user_id]);
$match = $stmt_check_match->fetch();

if (!$match) {
    // マッチングが存在しない場合はマッチングを挿入
    $sql_insert_match = "INSERT INTO matchs (user_id1, user_id2) VALUES (?, ?)";
    $stmt_insert_match = $pdo->prepare($sql_insert_match);
    if ($stmt_insert_match->execute([$logged_in_user_id, $user_id])) {
        echo "マッチングしました!";
    } else {
        echo "マッチングに失敗しました。";
    }
} else {
    echo "すでにマッチングしています。";
}
    ?>