<?php
$servername = "mysql301.phy.lolipop.lan";
$username = "LAA1517801";
$password = "pass0625";
$dbname = "LAA1517801-friends";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
session_start();
require '../db-connect.php'; // パスを確認

// セッションに`user_id`が設定されているか確認
if (!isset($_SESSION['user_id'])) {
    die("ユーザーIDがセッションに設定されていません。");
}

// URLパラメータに`matched_user_id`が設定されているか確認
if (!isset($_GET['matched_user_id'])) {
    die("マッチング相手のユーザーIDが指定されていません。");
}

$logged_in_user_id = $_SESSION['user_id'];
$matched_user_id = $_GET['matched_user_id'];

// 自分の情報を取得
$sql = "
    SELECT u.user_name, p.icon_image 
    FROM user u
    JOIN profile p ON u.user_id = p.user_id
    WHERE u.user_id = ?
";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("ステートメントの準備に失敗しました: " . $conn->error);
}
$stmt->bind_param("i", $logged_in_user_id);
$stmt->execute();
$result = $stmt->get_result();
$logged_in_user = $result->fetch_assoc();
if (!$logged_in_user) {
    die("ログインユーザーの情報取得に失敗しました。");
}

// 相手の情報を取得
$sql = "
    SELECT u.user_name, p.icon_image 
    FROM user u
    JOIN profile p ON u.user_id = p.user_id
    WHERE u.user_id = ?
";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("ステートメントの準備に失敗しました: " . $conn->error);
}
$stmt->bind_param("i", $matched_user_id);
$stmt->execute();
$result = $stmt->get_result();
$matched_user = $result->fetch_assoc();
if (!$matched_user) {
    die("マッチング相手の情報取得に失敗しました。");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マッチング通知</title>
    <style>
        .user-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin: 20px;
        }
        .user-info div {
            margin-left: 20px;
        }
        .buttons {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>マッチング通知</h1>
    <div class="user-info">
        <img src="../path/to/icons/<?php echo htmlspecialchars($logged_in_user['icon_image']); ?>" alt="Your Icon" class="user-icon">
        <div><?php echo htmlspecialchars($logged_in_user['user_name']); ?></div>
    </div>
    <div class="user-info">
        <img src="../path/to/icons/<?php echo htmlspecialchars($matched_user['icon_image']); ?>" alt="Matched User Icon" class="user-icon">
        <div><?php echo htmlspecialchars($matched_user['user_name']); ?></div>
    </div>
    <p><?php echo htmlspecialchars($matched_user['user_name']); ?>さんとマッチしました！</p>
    <div class="buttons">
        <button onclick="location.href='../talk_top.php'">はい</button>
        <button onclick="location.href='../top.php'">いいえ</button>
    </div>
</body>
</html>
