<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = $_POST['response'];

    if ($response === 'yes') {
        // トーク画面に遷移
        header("Location: talk_top.php");
        exit();
    } elseif ($response === 'no') {
        // トップ画面に遷移
        header("Location: top.php");
        exit();
    }
}
?>