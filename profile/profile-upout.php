<?php
session_start();
require '../db-connect.php';
$pdo=new PDO($connect,USER,PASS);
// update用
try{
    if(isset($_POST['btn'])&&$_POST['btn']==='submit'){
        // ユーザIDを保存
        $id=$_SESSION['user']['id'];
         //保存するフォルダの名前
        $main = 'user_image/main/';
        $sub = 'user_image/sub/';

        $subImg = array("subImage1", "subImage2", "subImage3");

        // アイコンをサーバーのフォルダに送信
        if(!empty($_FILES['icon']['name'])&&$_SESSION['user']['icon']<>$_FILES['icon']['name']){
            $fileName_main = basename($_FILES['icon']['name']);//登録したいファイルの名前
            $path = $main . $fileName_main;//二つをドッキング
            $fileType_main = pathinfo($path,PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType_main,$allowTypes)){
                if(move_uploaded_file($_FILES['icon']['tmp_name'],"../". $path)){
                    if (!exif_imagetype("../".$path)) {//画像ファイルかのチェック
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
            $update='update profile set icon_image=? where user_id=?';
            $sql=$pdo->prepare($update);
            $sql->execute([
                $_POST['icon'],$id
            ]);
        }
        $img='select sub_a_image,sub_b_image,sub_c_image from profile where user_id=?';
        $sql=$pdo->prepare($img);
        $sql->execute([$id]);
        $result = $sql->fetch();
        echo var_dump($result);
        if(!empty($_FILES[$subImg[0]]['name'])&&$_FILES[$subImg[0]]['name']<>$result[0]){
            //登録したいファイルの名前
            $fileName_subA = basename($_FILES[$subImg[0]]['name']);
            //二つをドッキング
            $subpath1 = $sub . $fileName_subA;
            $fileType_sub1 = pathinfo($subpath1,PATHINFO_EXTENSION);
            // 画像をサーバーにアップロード
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType_sub1,$allowTypes)){
                if(move_uploaded_file($_FILES[$subImg[0]]['tmp_name'],"../". $subpath1)){
                    if (!exif_imagetype("../".$subpath1)) {//画像ファイルかのチェック
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
        }
        if(!empty($_FILES[$subImg[1]]['name'])&&$_FILES[$subImg[1]]['name']<>$result[1]){
            //登録したいファイルの名前
            $fileName_subB = basename($_FILES[$subImg[1]]['name']);
            //二つをドッキング
            $subpath2 = $sub . $fileName_subB;
            // 画像パスの拡張子を変数に入れる
            $fileType_sub2 = pathinfo($subpath2,PATHINFO_EXTENSION);
            // 画像をサーバーにアップロード
            $allowTypes = array('jpg','png','jpeg','gif');
            if(in_array($fileType_sub2,$allowTypes)){
                if(move_uploaded_file($_FILES[$subImg[1]]['tmp_name'],"../". $subpath2)){
                    //画像ファイルかのチェック
                    if (!exif_imagetype("../".$subpath2)) {
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
        }
        if(!empty($_FILES[$subImg[2]]['name'])&&$_FILES[$subImg[2]]['name']<>$result[2]){
            //登録したいファイルの名前
            $fileName_subC = basename($_FILES[$subImg[2]]['name']);
            //二つをドッキング
            $subpath3 = $sub . $fileName_subC;
            // 画像パスの拡張子を変数に入れる
            $fileType_sub3 = pathinfo($subpath3,PATHINFO_EXTENSION);
            // 拡張子を変数に入れる
            $allowTypes = array('jpg','png','jpeg','gif');
            // 画像をサーバーにアップロード
            if(in_array($fileType_sub3,$allowTypes)){
                if(move_uploaded_file($_FILES[$subImg[2]]['tmp_name'],"../". $subpath3)){
                    //画像ファイルかのチェック
                    if (!exif_imagetype("../".$subpath3)) {
                        if (!empty($_SERVER['HTTP_REFERER'])){
                            header("Location:". $_SERVER['HTTP_REFERER']);
                        }
                    }
                }
            }
        }
    
        // echo var_dump($_POST);
        // 全てのサブ写真が設定されている場合
        if(!empty($fileName_subA)&&!empty($fileName_subB)&&!empty($fileName_subC)){
            $update='update user,profile set user_name=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    sub_a_image=?,sub_b_image=?,sub_c_image=?,alcohol=?,smoke=?
                    where user.user_id=?';
            $sql=$pdo->prepare($update);
            $sql->execute([
                $_POST['username'],$_POST['selfIntro'],$_POST['category'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['spendHoliday'],
                $fileName_subA,$fileName_subB,$fileName_subC,$_POST['drinking'],$_POST['smoking'],
                $id
            ]);
        // 1つ目のサブ写真が設定されている場合
        }else if(!empty($fileName_subA)){
            // 2つ目のサブ写真が設定されている場合
            if(!empty($fileName_subB)){
                $update='update user,profile set user_name=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    sub_a_image=?,sub_b_image=?,alcohol=?,smoke=?
                    where user.user_id=?';
                $sql=$pdo->prepare($update);
                $sql->execute([
                    $_POST['username'],$_POST['selfIntro'],$_POST['category'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['spendHoliday'],
                    $fileName_subA,$fileName_subB,$_POST['drinking'],$_POST['smoking'],$id,
                ]);
            // 3つ目のサブ写真が設定されている場合
            }else if(!empty($fileName_subC)){
                $update='update user,profile set user_name=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    sub_a_image=?,sub_c_image=?,alcohol=?,smoke=?
                    where user.user_id=?';
                $sql=$pdo->prepare($update);
                $sql->execute([
                    $_POST['username'],$_POST['selfIntro'],$_POST['category'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['spendHoliday'],
                    $fileName_subA,$fileName_subC,$_POST['drinking'],$_POST['smoking'],$id
                ]);
            }
            // 1つ目のサブ写真のみが設定されている場合
            $update='update user,profile set user_name=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    sub_a_image=?,alcohol=?,smoke=?
                    where user.user_id=?';
            $sql=$pdo->prepare($update);
            $sql->execute([
                $_POST['username'],$_POST['selfIntro'],$_POST['category'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['spendHoliday'],
                $fileName_subA,$_POST['drinking'],$_POST['smoking'],$id
            ]);
        // 2つ目のサブ写真が設定されている場合
        }else if(!empty($fileName_subB)){
            // 3つ目のサブ写真が設定されている場合
            if(!empty($fileName_subC)){
                $update='update userm,profile set user_name=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    sub_b_image=?,sub_c_image=?,alcohol=?,smoke=?
                    where user.user_id=?';
                $sql=$pdo->prepare($update);
                $sql->execute([
                    $_POST['username'],$_POST['selfIntro'],$_POST['category'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                    $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['spendHoliday'],
                    $fileName_subB,$fileName_subC,$_POST['drinking'],$_POST['smoking'],$id
                ]);
            }
            // 2つ目のサブ写真のみが設定されている場合
            $update='update user,profile set user_name=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    sub_b_image=?,alcohol=?,smoke=?
                    where user.user_id=?';
            $sql=$pdo->prepare($update);
            $sql->execute([
                $_POST['username'],$_POST['selfIntro'],$_POST['category'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['spendHoliday'],
                $fileName_subB,$_POST['drinking'],$_POST['smoking'],$id
            ]);
        // 3つ目のみに画像が設定されている場合
        }elseif(!empty($fileName_subC)){
            $update='update user,profile set user_name=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    sub_c_image=?,alcohol=?,smoke=?
                    where user.user_id=?';
            $sql=$pdo->prepare($update);
            $sql->execute([
                $_POST['username'],$_POST['selfIntro'],$_POST['category'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['spendHoliday'],
                $fileName_subC,$_POST['drinking'],$_POST['smoking'],$id
            ]);
        }else{
            $update='update user,profile set user_name=?,introduction=?,hobby_id=?,gender_id=?,
                    age=?,blood_type_id=?,school_id=?,birthplace_id=?,residence_id=?,holiday_spend=?,
                    alcohol=?,smoke=?
                    where user.user_id=?';
            $sql=$pdo->prepare($update);
            $sql->execute([
                $_POST['username'],$_POST['selfIntro'],$_POST['category'],$_POST['gender'],$_POST['age'],$_POST['bloodType'],
                $_POST['school'],$_POST['hometown'],$_POST['residence'],$_POST['spendHoliday'],
                $_POST['drinking'],$_POST['smoking'],$id
            ]);
        }
        // ｾｯｼｮﾝに性別、年齢、アイコン画像を設定
        $session='select user_id,gender_id,age,icon_image from user,profile where user.user_id=?';
        $sql=$pdo->prepare($session);
        $sql->execute([$id]);
        foreach($sql as $row){
            $_SESSION['user']=[
                'id'=>$row['user_id'],'name'=>$row['user_name'],'gender'=>$row['gender_id'],'age'=>$row['age'],'icon'=>$row['icon_image']
            ];
        }
        トップへ飛ぶ
        echo <<<EOS
            <script>
                location.href='https://aso2201147.tonkotsu.jp/Friends/profile/profile_up.php';
            </script> 
        \n
        EOS;
    }
}catch(\Exception $e){
    echo 'エラー発生:' . $e->getMessage();
}
?>