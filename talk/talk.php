<?php require '../db-connect.php';?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>トーク</title>
    <link rel="stylesheet" href="talk.css">
    <script src="https://kit.fontawesome.com/75b2488170.js" crossorigin="anonymous"></script>
    <script src=""></script>
</head>
<body>
    <div class="talk-system">
        <div class="talk-box">
            <div class="talk-area" id="talk-area">
                <?php echo $result; ?>
                <?php echo var_dump($result); ?>
            </div>
        <form class="send-box flex-box" action="talk.php#talk-area" method="post">
            <textarea id="textarea" type="text" name="text" rows="1" required placeholder="message"></textarea>
            <input type="submit" name="submit" value="送信" id="serch">
            <label for="serch"><i class="fa-regular fa-paper-plane"></i></label>
        </form>
        </div>
    </div>
</body>
</html>

<?php
$J_file = "talklog.json";
date_default_timezone_set('Asia/Tokyo');// タイムゾーンを日本にセット
// $pdo=new PDO($connect,USER,PASS);

// $imagePath=$pdo->prepare('select icon_image from');
// 画像パスをとってくる（talk,user,profileテーブルを結合してprofileテーブルからicon_imageを取得）
// $userId=$pdo->prepare();// ユーザID
// $userName=$pdo->prepare();// ユーザネーム
if(isset($_POST['submit'])&&$_POST['submit']==="送信"){
    $talk=[];
    $talk["person"]="person1";
    $talk["imgPath"]="#";
    $talk["text"]=htmlspecialchars($_POST['text'],ENT_QUOTES);

    // 入力値格納処理
    if($file=file_get_contents($J_file)){
        // ファイルがある場合、追記処理
        $fiie=str_replace(array(" ","\n","\r"),"",$file);// ファイルデータの中の空白や改行を削除
        $file=mb_substr($file,0,mb_strlen($file)-2);// ファイルデータ末尾の']}'の2文字を削除
        $json=json_encode($talk);// talk配列のデータをエンコード
        $json=$file.','.$json.']}';// 連想配列に格納する前準備（後ろ側を付与）ファイルデータ＋新トークログ
        file_put_contents($J_file,$json,LOCK_EX);// ファイルを上書き＆データを格納
    }else{
        // ファイルがない場合、新規作成処理
        $json=json_encode($talk);// talk配列のデータをエンコード
        $json='{"talklog":['.$json.']}';// 連想配列に格納する前準備（前側を付与）
        file_put_contents($J_file,$json,FILE_APPEND | LOCK_EX);// ファイルを作成＆データを格納
    }

    header('Location:./talk.php');
    exit;
}
if($file=file_get_contents($J_file)){// ログがあるかの判定
    $file=json_decode($file);
    $array=$file->talklog;
    foreach($array as $object){
        if(isset($result)){
            // 二回目以降
            $result=$result.'<div class=">'.$object->person.'"><p class="talk">'.str_replace("\r\n","<br>",$object->text).'</p><img src="'.$object->imgPath.'"></div>';
        }else{
            // 一回目
            $result='<div class="'.$object->person.'"><p class="talk">'.str_replace("\r\n","<br>",$object->text).'</p><img src="'.$object->imgPath.'"></div>';
        }
    }
}
?>