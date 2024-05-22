<?php
const SERVER = 'mysql301.phy.lolipop.lan';
const DBNAME = 'LAA1517801-friends';
const USER = 'LAA1517801';
const PASS = 'pass0625';

$conn = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>いいね一覧</title>
</head>
<body>
いいねした人<button onclick="location.href='./youlike.php'">あなたへいいね</button>
  <ul>
    <?php while ($row = $result_liked->fetch_assoc()) { ?>
      <li><?php echo htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['age']) . ") - " . htmlspecialchars($row['bio']); ?></li>
    <?php } ?>
  </ul>
</body>
</html>
?>