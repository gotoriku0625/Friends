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
 require '../db-connect.php';// データベース接続を含む
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id1 = $_POST['user_id1']; // ユーザー1のID
    $user_id2 = $_POST['user_id2']; // ユーザー2のID
 
    // ユーザー2がユーザー1にいいねしているかチェック
    $sql = "SELECT * FROM likes WHERE likes_user_id = ? AND liked_user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id2, $user_id1);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($result->num_rows > 0) {
        // マッチングが成立した場合、マッチング情報を挿入
        $sql = "INSERT INTO matchs (user_id1, user_id2) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id1, $user_id2);
 
        if ($stmt->execute()) {
            echo "マッチングが成立しました。";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "まだマッチングしていません。";
    }
 
    $stmt->close();
}
 
$conn->close();
?>