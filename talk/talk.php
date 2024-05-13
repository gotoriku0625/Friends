<?php require '../db-connect.php';?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>トーク</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="css/fontawesome-free-5.15.3-web/css/all.min.css">
    <script src=""></script>
</head>
<body>
    <div class="talk-system">
        <form class="send-box flex-box" action="talk.php#talk-area" method="post">
            <textarea id="textarea" type="text" name="text" rows="1" required placeholder="message"></textarea>
            <input type="submit" name="submit" value="送信" id="send">
            <label for="send"><i class="fa-regular fa-paper-plane"></i></label>
        </form>
    </div>
</body>
</html>

<?php
$J_file = "chatlog.json";
date_default_timezone_set('Asia/Tokyo');// タイムゾーンを日本にセット
$pdo=new PDO($connect,USER,PASS);

$imagePath=$pdo->prepare('select icon_image from');
// 画像パスをとってくる（talk,user,profileテーブルを結合してprofileテーブルからicon_imageを取得）
$userId=$pdo->query();
if(isset($_POST['submit']&&$_POST['submit']==="送信")){
    $talk=[];
    $talk["person"]="person1";
    $talk["imgPath"]="";
    $talk["text"]=htmlspecialchars($_POST['text'],ENT_QUOTES);
}
?>