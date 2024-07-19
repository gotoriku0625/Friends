<?php session_start();

if (!isset($_SESSION['match_message']) || !isset($_SESSION['reciver_id'])) {
    header("Location: top.php");
    exit;
}

$match_message = $_SESSION['match_message'];
$reciver_id = $_SESSION['reciver_id'];

// データベース接続
require '../db-connect.php';
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ログインユーザーのアイコンを取得
$default_icon = '../user_image/main/1.png';
$user_icon_path = $default_icon;
$receiver_icon_path = $default_icon;

// ログインユーザーの情報を取得
$sql = 'SELECT icon_image FROM profile WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
$stmt->execute();
$user_profile = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user_profile) {
    $user_icon_path = empty($user_profile['icon_image']) ? $default_icon : "../user_image/main/{$user_profile['icon_image']}";
}

// 相手ユーザーの情報を取得
$sql = 'SELECT u.user_name, p.icon_image 
        FROM user u
        LEFT JOIN profile p ON u.user_id = p.user_id
        WHERE u.user_id = :reciver_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':reciver_id', $reciver_id, PDO::PARAM_INT);
$stmt->execute();
$receiver_profile = $stmt->fetch(PDO::FETCH_ASSOC);

if ($receiver_profile) {
    $receiver_user_name = htmlspecialchars($receiver_profile['user_name'], ENT_QUOTES, 'UTF-8');
    $receiver_icon_path = empty($receiver_profile['icon_image']) ? $default_icon : "../user_image/main/{$receiver_profile['icon_image']}";
} else {
    $receiver_user_name = '不明';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="mach_succes.css">
    <title>マッチング成功</title>
</head>
<body>
    <div class="container">
        <div class="logo-space">
            <img src="../image/logo.png" class="logo">
        </div>

        <div class="icons-container">
            <!-- ログインユーザーのアイコン表示 -->
            <div class="login-user-icon">
                <img src="<?php echo htmlspecialchars($user_icon_path, ENT_QUOTES, 'UTF-8'); ?>" alt="ログインユーザーアイコン" class="mach-user-icon1">
            </div>

            <img src="../image/mach.png" class="mach-image">

            <!-- 相手ユーザーのアイコン表示 -->
            <div class="receiver-user-icon">
                <img src="<?php echo htmlspecialchars($receiver_icon_path, ENT_QUOTES, 'UTF-8'); ?>" alt="相手ユーザーアイコン" class="mach-user-icon2">
            </div>
        </div>

        <p><?php echo htmlspecialchars($receiver_user_name); ?>さんと<?php echo htmlspecialchars($match_message); ?></p>

        <form method="POST" action="talk_or_top.php">
            <input type="hidden" name="reciver_id" value="<?php echo htmlspecialchars($reciver_id); ?>">
            <p>トークへいきますか？</p>
            <button type="submit" name="action" value="talk">はい</button>
            <button type="submit" name="action" value="top">いいえ</button>
        </form>
    </div>
</body>
</html>
