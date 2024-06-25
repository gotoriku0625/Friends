<?php
session_start();
require '../db-connect.php';
$pdo=new PDO($connect,USER,PASS);
// update用
try{
    if(isset($_POST['btn'])&&$_POST['btn']==='submit'){
        
         //保存するフォルダの名前
        $main = 'user_image/main/';
        $sub = 'user_image/sub/';

        $subImg = array("subImage1", "subImage2", "subImage3");

        // アイコンをサーバーのフォルダに送信
        if(!empty($_FILES['icon']['name'])){
            $fileName_main = basename($_FILES['icon']['name']);//登録したいファイルの名前
            $path = $main . $fileName_main;//二つをドッキング
            $fileType_main = pathinfo($path,PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType,$allowTypes)){
                if(move_uploaded_file($_FILES['icon']['tmp_name'],"../". $path)){
                    if (!exif_imagetype("../".$path)) {//画像ファイルかのチェック
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
        }

        if($_POST[$subImg[0]]){
            //登録したいファイルの名前
            $fileName_sub1 = basename($_FILES[$subImg[0]]['name']);
            //二つをドッキング
            $subpath1 = $sub . $fileName_sub1;
            $fileType_sub1 = pathinfo($subpath1,PATHINFO_EXTENSION);
            // 画像をサーバーにアップロード
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType,$allowTypes)){
                if(move_uploaded_file($_FILES[$subImg[0]]['tmp_name'],"../". $path)){
                    if (!exif_imagetype("../".$path)) {//画像ファイルかのチェック
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
        }
        if($_POST[$subImg[1]]){
            //登録したいファイルの名前
            $fileName_sub1 = basename($_FILES[$subImg[1]]['name']);
            //二つをドッキング
            $subpath2 = $sub . $fileName_sub2;
            // 画像パスの拡張子を変数に入れる
            $fileType_sub2 = pathinfo($subpath2,PATHINFO_EXTENSION);
            // 画像をサーバーにアップロード
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType,$allowTypes)){
                if(move_uploaded_file($_FILES[$subImg[1]]['tmp_name'],"../". $path)){
                    //画像ファイルかのチェック
                    if (!exif_imagetype("../".$path)) {
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
        }
        if($_POST[$subImg[2]]){
            //登録したいファイルの名前
            $fileName_sub1 = basename($_FILES[$subImg[2]]['name']);
            //二つをドッキング
            $subpath3 = $sub . $fileName_sub3;
            // 画像パスの拡張子を変数に入れる
            $fileType_sub3 = pathinfo($subpath3,PATHINFO_EXTENSION);
            // 画像をサーバーにアップロード
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType,$allowTypes)){
                if(move_uploaded_file($_FILES[$subImg[2]]['tmp_name'],"../". $path)){
                    //画像ファイルかのチェック
                    if (!exif_imagetype("../".$path)) {
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
        }
    
        $select='select user_id from user where user_id=?';
        $id = $pdo->prepare($select);
        $id->execute([$_SESSION['user']['id']]);

        // 全てのサブ写真が設定されている場合
        if($_POST['subPhoto1']&&$_POST['subPhoto2']&&$_POST['subPhoto3']){
            $update='update profile set user_id=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    icon_image=?,sub_a_image=?,sub_b_image=?,sub_c_image=?,alcohol=?,smoke=?';
            $sql=$pdo->prepare($update);
            $sql->execute([
                $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                $_POST['subPhoto1'],$_POST['subPhoto2'],$_POST['subPhoto3'],$drinking,$smoking
            ]);
        // 1つ目のサブ写真が設定されている場合
        }else if($_POST['subPhoto1']){
            // 2つ目のサブ写真が設定されている場合
            if($_POST['subPhot2']){
                $update='update profile set user_id=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    icon_image=?,sub_a_image=?,sub_b_image=?,alcohol=?,smoke=?';
                $sql=$pdo->prepare($insert);
                $sql->execute([
                    $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                    $_POST['subPhoto1'],$_POST['subPhoto2'],$drinking,$smoking
                ]);
            // 3つ目のサブ写真が設定されている場合
            }else if($_POST['subPhot3']){
                $update='update profile set user_id=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    icon_image=?,sub_a_image=?,sub_c_image=?,alcohol=?,smoke=?';
                $sql=$pdo->prepare($insert);
                $sql->execute([
                    $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                    $_POST['subPhoto1'],$_POST['subPhoto3'],$drinking,$smoking
                ]);
            }
            // 1つ目のサブ写真のみが設定されている場合
            $update='update profile set user_id=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    icon_image=?,sub_a_image=?,alcohol=?,smoke=?';
            $sql=$pdo->prepare($insert);
            $sql->execute([
                $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                $_POST['subPhoto1'],$drinking,$smoking
            ]);
        // 2つ目のサブ写真が設定されている場合
        }else if($_POST['subPhoto2']){
            // 3つ目のサブ写真が設定されている場合
            if($_POST['subPhot3']){
                $update='update profile set user_id=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    icon_image=?,sub_b_image=?,sub_c_image=?,alcohol=?,smoke=?';
                $sql=$pdo->prepare($insert);
                $sql->execute([
                    $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                    $_POST['subPhoto2'],$_POST['subPhoto3'],$drinking,$smoking
                ]);
            }
            // 2つ目のサブ写真のみが設定されている場合
            $update='update profile set user_id=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    icon_image=?,sub_b_image=?,alcohol=?,smoke=?';
            $sql=$pdo->prepare($insert);
            $sql->execute([
                $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                $_POST['subPhoto2'],$drinking,$smoking
            ]);
        // 3つ目のみに画像が設定されている場合
        }else{
            $update='update profile set user_id=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    icon_image=?,sub_c_image=?,alcohol=?,smoke=?';
            $sql=$pdo->prepare($insert);
            $sql->execute([
                $id,$_POST['selfIntro'],$_POST['hobbies'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['message'],$_POST['profileIcon'],
                $_POST['subPhoto3'],$drinking,$smoking
            ]);
        }
        // ｾｯｼｮﾝに性別、年齢、アイコン画像を設定
        foreach($sql as $row){
            $_SESSION['user']=[
                'gender'=>$row['gender_id'],'age'=>$row['age'],'icon'=>$row['icon_image']
            ];
        }
        // トップへ飛ぶ
        header("Location: ../top/top.php");
        exit;
    }
}catch(\Exception $e){
    echo 'エラー発生:' . $e->getMessage();
}
?>