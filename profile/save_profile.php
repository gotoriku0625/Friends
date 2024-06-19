<?php
    // 定数を使用してデータベース接続情報を定義
    const SERVER = 'mysql301.phy.lolipop.lan';
    const DBNAME = 'LAA1517801-friends';
    const USER = 'LAA1517801';
    const PASS = 'pass0625';
 
    $dsn = 'mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8';
    $user = USER;
    $password = PASS;

try {
    // データベース接続
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // フォームから送信されたデータの受け取り
    $username = $_POST['username'];
    $selfIntro = $_POST['selfIntro'];
    $hobbies = $_POST['hobbies'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $bloodType = $_POST['bloodType'];
    $school = $_POST['school'];
    $hometown = $_POST['hometown'];
    $residence = $_POST['residence'];
    $spendHoliday = $_POST['spendHoliday'];
    $alcohol = isset($_POST['alcohol']) ? 1 : 0;
    $smoking = isset($_POST['smoking']) ? 1 : 0;

    // 画像ファイルの処理
    $iconImage = $_FILES['iconImage']['name'];
    $subAImage = $_FILES['subAImage']['name'];
    $subBImage = $_FILES['subBImage']['name'];
    $subCImage = $_FILES['subCImage']['name'];

    // 画像のアップロード
    move_uploaded_file($_FILES['iconImage']['tmp_name'], "uploads/" . $iconImage);
    move_uploaded_file($_FILES['subAImage']['tmp_name'], "uploads/" . $subAImage);
    move_uploaded_file($_FILES['subBImage']['tmp_name'], "uploads/" . $subBImage);
    move_uploaded_file($_FILES['subCImage']['tmp_name'], "uploads/" . $subCImage);

    // データベースへの挿入
    $stmt = $pdo->prepare("INSERT INTO profiles (username, introduction, hobbies, gender, age, blood_type, school, hometown, residence, spend_holiday, alcohol, smoke, icon_image, sub_a_image, sub_b_image, sub_c_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $selfIntro, $hobbies, $gender, $age, $bloodType, $school, $hometown, $residence, $spendHoliday, $alcohol, $smoking, $iconImage, $subAImage, $subBImage, $subCImage]);

    echo "プロフィールが保存されました。";
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>
