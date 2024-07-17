<?php
session_start();
require '../db-connect.php'; // データベース接続情報を含むファイル

try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // エラーメッセージをログに記録して表示しないようにする
    error_log("DB接続エラー: " . $e->getMessage());
    die("データベース接続に失敗しました");
}

// ユーザーIDはセッションから取得
if (isset($_SESSION['user']['id'])) {
    $logged_in_user_id = $_SESSION['user']['id'];
} else {
    die("ユーザーがログインしていません。");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reciver_id'])) {
        $matched_user_id = $_POST['reciver_id'];
    } else {
        die("受信者IDが設定されていません。");
    }

    $action = $_POST['action'];

    try {
        // talk_memberに登録する
        $sql = "INSERT INTO talk_member (sender_id, reciver_id) VALUES (?, ?), (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$logged_in_user_id, $matched_user_id, $matched_user_id, $logged_in_user_id]);

        // 遷移先を設定
        if ($action == 'talk') {
            echo '<form name="add" action="../talk/talk2.php" method="post">';
                echo '<input type="hidden" name="reciver_id" value="'.$matched_user_id.'">';
                echo '<SCRIPT language="JavaScript">document.add.submit();</SCRIPT>';
            echo '</form>';
        } else {
            header("Location: ../top/top.php");
        }
        exit;
    } catch (PDOException $e) {
        // エラーメッセージをログに記録して表示しないようにする
        error_log("SQLエラー: " . $e->getMessage());
        die("データベース操作中にエラーが発生しました。");
    }
} else {
    die("無効なリクエストです。");
}
?>
