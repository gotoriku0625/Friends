<?php
session_start();

if (!isset($_SESSION['match_message']) || !isset($_SESSION['reciver_id'])) {
    header("Location: top.php");
    exit;
}

$match_message = $_SESSION['match_message'];
$reciver_id = $_SESSION['reciver_id'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マッチング成功</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($match_message); ?></h1>
    <form method="POST" action="talk_or_top.php">
        <input type="hidden" name="reciver_id" value="<?php echo htmlspecialchars($reciver_id); ?>">
        <button type="submit" name="action" value="talk">トーク</button>
        <button type="submit" name="action" value="top">トップ</button>
    </form>
</body>
</html>
