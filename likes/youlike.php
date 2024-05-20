<?php
$servername = 'mysql301.phy.lolipop.lan';
$username = 'LAA1517801';
$password = 'pass0625';
$dbname = 'LAA1517793-friends';

// データベース接続の作成
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続をチェック
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<?php
session_start();
$current_user_id = $_SESSION['user_id'];  // ログインユーザーのID

// いいねした人を取得
$sql_liked = "SELECT u.id, u.name, u.age, u.bio
              FROM likes l
              JOIN users u ON l.liked_user_id = u.id
              WHERE l.user_id = ?";
$stmt_liked = $conn->prepare($sql_liked);
$stmt_liked->bind_param("i", $current_user_id);
$stmt_liked->execute();
$result_liked = $stmt_liked->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>いいね一覧</title>
</head>
<body>
  <h1>いいねされた人</h1>
  <ul>
    <?php while ($row = $result_liked_by->fetch_assoc()) { ?>
      <li><?php echo htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['age']) . ") - " . htmlspecialchars($row['bio']); ?></li>
    <?php } ?>
  </ul>
</body>
</html>

<?php
$conn->close();
?>