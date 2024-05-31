<?php
require '../db-connect.php'
$pdo = new PDO($connect,USER,PASS);
echo var_dump($pdo);
if (isset($_POST['send'])) {
  $user_name = $_POST['user_name'];
  $content = $_POST['content'];

  $sql = "INSERT INTO talk (sender_id,reciver_id,content) VALUES (:sender_id,:reciver_id,:content)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
  $stmt->bindParam(':content', $content, PDO::PARAM_STR);
  $stmt->execute();
}

$sql = "SELECT * FROM talk ORDER BY talk_id DESC";
$stmt = $pdo->query($sql);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>チャットルーム</title>
  <style>
    .message {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <h1>チャットルーム</h1>
  <?php foreach ($messages as $message): ?>
  <div class="message">
    <p><strong><?php echo htmlspecialchars($message['user_name']); ?></strong></p>
    <p><?php echo htmlspecialchars($message['content']); ?></p>
  </div>
  <?php endforeach; ?>
</body>
</html>